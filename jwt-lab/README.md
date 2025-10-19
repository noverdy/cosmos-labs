# JWT Security Lab - SICOSMOS

## Overview
SICOSMOS (Sistem Informasi Cosmos) is a JWT security lab demonstrating weak signing key vulnerabilities implemented in Go with real database integration.

## Vulnerability
The application uses JWT tokens signed with HS256 algorithm using a weak, predictable secret key: `jwtislove2`

## Features
- User registration and login with MySQL database
- Role-based dashboard (Admin vs Regular user)
- JWT token-based authentication
- Real database persistence
- Built with Go and vanilla HTML/CSS/JS (no npm dependencies)

## Access
- **URL**: http://localhost:8084

## Vulnerability Details
1. JWT tokens are signed using HS256 with weak secret key `jwtislove2`
2. The `userID` claim in JWT payload determines user privileges (admin access if userID == 1)
3. Attackers can forge admin tokens by creating JWT with `userID: 1`
4. Authorization logic checks if userID == 1 for admin access

## Exploitation Steps
1. Login as regular user to get a valid JWT token
2. Decode the JWT to understand its structure (contains userID)
3. Create a new JWT with `userID: 1` using the weak secret `jwtislove2`
4. Use the forged token to access admin dashboard

## Database Schema
- **users table**: id, username, password, email, full_name, role, created_at, updated_at, last_login
- **Admin user**: Always has userID 1
- **Regular users**: Assigned userID 2, 3, 4, etc.

## Authorization Logic
```go
// Admin access check
if user.ID == 1 {
    // Admin dashboard
} else {
    // Regular user dashboard
}
```

## Mitigation
- Use strong, random secret keys for JWT signing
- Consider using asymmetric algorithms (RS256) instead of symmetric (HS256)
- Implement server-side role validation instead of client-side userID checks
- Use short token expiration times
- Validate user roles from database, not just userID

## Technology Stack
- **Backend**: Go with Gin framework
- **Database**: MySQL 8.0
- **Frontend**: Vanilla HTML, CSS, JavaScript
- **Authentication**: JWT with HS256 (intentionally weak for demo)
- **Containerization**: Docker with docker-compose