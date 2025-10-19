package main

import (
	"database/sql"
	"fmt"
	"net/http"
	"os"
	"strings"
	"time"

	"github.com/gin-gonic/gin"
	_ "github.com/go-sql-driver/mysql"
	"github.com/golang-jwt/jwt/v5"
	"golang.org/x/crypto/bcrypt"
)

type User struct {
	ID       int    `json:"id"`
	Username string `json:"username"`
	Password string `json:"-"`
	Email    string `json:"email"`
	FullName string `json:"fullName"`
	Role     string `json:"role"`
}

type Claims struct {
	UserID int `json:"userID"`
	jwt.RegisteredClaims
}

var db *sql.DB

const JWT_SECRET = "jwtislove2"

func initDB() {
	dbHost := os.Getenv("DB_HOST")
	if dbHost == "" {
		dbHost = "localhost"
	}

	dbPort := os.Getenv("DB_PORT")
	if dbPort == "" {
		dbPort = "3306"
	}

	dbName := os.Getenv("DB_NAME")
	if dbName == "" {
		dbName = "sicosmos_db"
	}

	dbUser := os.Getenv("DB_USER")
	if dbUser == "" {
		dbUser = "jwtuser"
	}

	dbPassword := os.Getenv("DB_PASSWORD")
	if dbPassword == "" {
		dbPassword = "jwtpass"
	}

	dsn := fmt.Sprintf("%s:%s@tcp(%s:%s)/%s?parseTime=true", dbUser, dbPassword, dbHost, dbPort, dbName)

	var err error
	for i := 0; i < 10; i++ {
		db, err = sql.Open("mysql", dsn)
		if err != nil {
			fmt.Printf("Failed to connect to database (attempt %d): %v\n", i+1, err)
			time.Sleep(2 * time.Second)
			continue
		}

		err = db.Ping()
		if err == nil {
			fmt.Println("Successfully connected to database")
			break
		}

		fmt.Printf("Failed to ping database (attempt %d): %v\n", i+1, err)
		time.Sleep(2 * time.Second)
	}

	if err != nil {
		panic(fmt.Sprintf("Failed to connect to database after 10 attempts: %v", err))
	}
}

func main() {
	initDB()
	defer db.Close()

	r := gin.Default()

	r.Static("/static", "./static")
	r.LoadHTMLGlob("templates/*")
	r.GET("/", func(c *gin.Context) {
		c.HTML(http.StatusOK, "index.html", gin.H{
			"title": "SICOSMOS - Enterprise Information Management System",
		})
	})

	r.GET("/login", func(c *gin.Context) {
		c.HTML(http.StatusOK, "login.html", gin.H{
			"title": "Login - SICOSMOS",
		})
	})

	r.GET("/register", func(c *gin.Context) {
		c.HTML(http.StatusOK, "register.html", gin.H{
			"title": "Register - SICOSMOS",
		})
	})

	r.GET("/dashboard", authMiddleware(), func(c *gin.Context) {
		userID, exists := c.Get("userID")
		if !exists {
			c.Redirect(http.StatusFound, "/login")
			return
		}

		user, err := getUserByID(userID.(int))
		if err != nil {
			c.Redirect(http.StatusFound, "/login")
			return
		}

		if user.ID == 1 {
			c.HTML(http.StatusOK, "admin_dashboard.html", gin.H{
				"title": "Admin Dashboard - SICOSMOS",
				"user":  user,
			})
		} else {
			c.HTML(http.StatusOK, "user_dashboard.html", gin.H{
				"title": "Dashboard - SICOSMOS",
				"user":  user,
			})
		}
	})

	r.POST("/api/login", loginHandler)
	r.POST("/api/register", registerHandler)
	r.GET("/api/dashboard", authMiddleware(), dashboardHandler)

	fmt.Println("SICOSMOS server starting on port 8080...")
	r.Run(":8080")
}

func authMiddleware() gin.HandlerFunc {
	return func(c *gin.Context) {
		tokenString := c.GetHeader("Authorization")
		if tokenString == "" {
			// Try to get token from cookie
			cookie, err := c.Cookie("token")
			if err != nil {
				c.JSON(http.StatusUnauthorized, gin.H{"error": "Authorization token required"})
				c.Abort()
				return
			}
			tokenString = cookie
		} else {
			// Remove "Bearer " prefix
			tokenString = strings.TrimPrefix(tokenString, "Bearer ")
		}

		token, err := jwt.ParseWithClaims(tokenString, &Claims{}, func(token *jwt.Token) (interface{}, error) {
			return []byte(JWT_SECRET), nil
		})

		if err != nil {
			c.JSON(http.StatusUnauthorized, gin.H{"error": "Invalid token"})
			c.Abort()
			return
		}

		if claims, ok := token.Claims.(*Claims); ok && token.Valid {
			_, err := getUserByID(claims.UserID)
			if err != nil {
				c.JSON(http.StatusUnauthorized, gin.H{"error": "User not found"})
				c.Abort()
				return
			}

			c.Set("userID", claims.UserID)
			c.Next()
			return
		}

		c.JSON(http.StatusUnauthorized, gin.H{"error": "Invalid token"})
		c.Abort()
	}
}

func getUserByID(id int) (*User, error) {
	var user User
	err := db.QueryRow("SELECT id, username, email, full_name, role FROM users WHERE id = ?", id).Scan(
		&user.ID, &user.Username, &user.Email, &user.FullName, &user.Role,
	)
	if err != nil {
		return nil, err
	}
	return &user, nil
}

func getUserByUsername(username string) (*User, error) {
	var user User
	err := db.QueryRow("SELECT id, username, password, email, full_name, role FROM users WHERE username = ?", username).Scan(
		&user.ID, &user.Username, &user.Password, &user.Email, &user.FullName, &user.Role,
	)
	if err != nil {
		return nil, err
	}
	return &user, nil
}

func createUser(username, password, email, fullName string) (*User, error) {
	hashedPassword, err := bcrypt.GenerateFromPassword([]byte(password), bcrypt.DefaultCost)
	if err != nil {
		return nil, err
	}

	result, err := db.Exec("INSERT INTO users (username, password, email, full_name, role) VALUES (?, ?, ?, ?, 'user')",
		username, string(hashedPassword), email, fullName)
	if err != nil {
		return nil, err
	}

	id, err := result.LastInsertId()
	if err != nil {
		return nil, err
	}

	return &User{
		ID:       int(id),
		Username: username,
		Email:    email,
		FullName: fullName,
		Role:     "user",
	}, nil
}

func getTotalUsers() (int, error) {
	var count int
	err := db.QueryRow("SELECT COUNT(*) FROM users").Scan(&count)
	return count, err
}

func loginHandler(c *gin.Context) {
	var req struct {
		Username string `json:"username" binding:"required"`
		Password string `json:"password" binding:"required"`
	}

	if err := c.ShouldBindJSON(&req); err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": "Invalid request"})
		return
	}

	// Find user in database
	user, err := getUserByUsername(req.Username)
	if err != nil {
		c.JSON(http.StatusUnauthorized, gin.H{"error": "Invalid credentials"})
		return
	}

	// Verify password
	if err := bcrypt.CompareHashAndPassword([]byte(user.Password), []byte(req.Password)); err != nil {
		c.JSON(http.StatusUnauthorized, gin.H{"error": "Invalid credentials"})
		return
	}

	// Update last login
	db.Exec("UPDATE users SET last_login = NOW() WHERE id = ?", user.ID)

	// Create token with only userID
	expirationTime := time.Now().Add(24 * time.Hour)
	claims := &Claims{
		UserID: user.ID,
		RegisteredClaims: jwt.RegisteredClaims{
			ExpiresAt: jwt.NewNumericDate(expirationTime),
		},
	}

	token := jwt.NewWithClaims(jwt.SigningMethodHS256, claims)
	tokenString, err := token.SignedString([]byte(JWT_SECRET))
	if err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": "Could not create token"})
		return
	}

	// Set cookie
	c.SetCookie("token", tokenString, 86400, "/", "", false, true)

	// Check if admin (userID == 1)
	isAdmin := user.ID == 1

	c.JSON(http.StatusOK, gin.H{
		"message": "Login successful",
		"token":   tokenString,
		"user": gin.H{
			"id":       user.ID,
			"username": user.Username,
			"isAdmin":  isAdmin,
		},
	})
}

func registerHandler(c *gin.Context) {
	var req struct {
		Username string `json:"username" binding:"required"`
		Password string `json:"password" binding:"required"`
		Email    string `json:"email"`
		FullName string `json:"fullName"`
	}

	if err := c.ShouldBindJSON(&req); err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": "Invalid request"})
		return
	}

	// Check if user exists
	_, err := getUserByUsername(req.Username)
	if err == nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": "User already exists"})
		return
	}

	// Create new user (always role 'user' for registration)
	newUser, err := createUser(req.Username, req.Password, req.Email, req.FullName)
	if err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": "Could not create user"})
		return
	}

	// New users are never admin (admin is always userID == 1)
	c.JSON(http.StatusCreated, gin.H{
		"message": "User created successfully",
		"user": gin.H{
			"id":       newUser.ID,
			"username": newUser.Username,
			"isAdmin":  false,
		},
	})
}

func dashboardHandler(c *gin.Context) {
	userID, exists := c.Get("userID")
	if !exists {
		c.JSON(http.StatusUnauthorized, gin.H{"error": "User not found"})
		return
	}

	user, err := getUserByID(userID.(int))
	if err != nil {
		c.JSON(http.StatusUnauthorized, gin.H{"error": "User not found"})
		return
	}

	totalUsers, _ := getTotalUsers()

	// Check if admin (userID == 1)
	if user.ID == 1 {
		// Admin dashboard - complex looking response
		c.JSON(http.StatusOK, gin.H{
			"message": "Welcome to SICOSMOS Admin Dashboard",
			"user":    user,
			"dashboard": gin.H{
				"systemStats": gin.H{
					"totalUsers":     totalUsers,
					"activeSessions": 142,
					"systemLoad":     "67%",
					"memoryUsage":    "45%",
					"networkTraffic": "847 GB",
				},
				"modules": []gin.H{
					{"name": "User Management", "status": "Active", "users": totalUsers},
					{"name": "System Monitoring", "status": "Active", "metrics": 1250},
					{"name": "Security Audit", "status": "Active", "alerts": 7},
					{"name": "Database Administration", "status": "Active", "queries": 8472},
					{"name": "Network Configuration", "status": "Active", "devices": 23},
					{"name": "Backup Management", "status": "Active", "backups": 142},
					{"name": "Performance Analytics", "status": "Active", "reports": 89},
					{"name": "Access Control", "status": "Active", "policies": 34},
				},
				"recentActivity": []gin.H{
					{"action": "System Backup", "time": time.Now().Format(time.RFC3339), "user": "system"},
					{"action": "Security Scan", "time": time.Now().Format(time.RFC3339), "user": "security_bot"},
					{"action": "User Login", "time": time.Now().Format(time.RFC3339), "user": user.Username},
					{"action": "Database Update", "time": time.Now().Format(time.RFC3339), "user": "admin"},
					{"action": "Config Change", "time": time.Now().Format(time.RFC3339), "user": "system"},
				},
				"adminTools": []string{
					"User Account Management",
					"System Configuration",
					"Security Policy Editor",
					"Database Query Tool",
					"Log File Analyzer",
					"Performance Monitor",
					"Backup Scheduler",
					"Network Diagnostics",
				},
			},
		})
	} else {
		// Regular user dashboard - simple response
		c.JSON(http.StatusOK, gin.H{
			"message": "Welcome to SICOSMOS Dashboard",
			"user":    user,
			"dashboard": gin.H{
				"basicInfo": gin.H{
					"accountType":   "Standard User",
					"lastLogin":     time.Now().Format(time.RFC3339),
					"accountStatus": "Active",
				},
				"availableFeatures": []string{
					"View Profile",
					"Change Password",
				},
			},
		})
	}
}
