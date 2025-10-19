# SQL Injection Lab - COSMOS Apps

## Overview
This lab demonstrates SQL Injection vulnerabilities in a classroom management system called "COSMOS Apps". The application has a vulnerable login system that allows students to bypass authentication using SQL injection techniques.

## Vulnerability
The login system is vulnerable to SQL Injection in the password field. The vulnerable query is:

```php
$query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
```

## Application Structure

### User Roles
- **Administrator (Teacher)**: Manages the classroom system
- **Student**: Regular user with limited privileges

## SQL Injection Attack Scenarios

### 1. Classic SQL Injection (Bypass Authentication)
**Goal**: Login as any user without knowing their password

**Payload**:
```sql
' OR '1'='1
```

**Example**:
- Username: `admin`
- Password: `' OR '1'='1`

**Result**: Login successful as admin user

### 2. Username-based SQL Injection
**Goal**: Login as a specific user by manipulating the username field

**Payload**:
```sql
admin' --
```

**Example**:
- Username: `admin' --`
- Password: `anything`

**Result**: Login successful as admin (comment bypasses password check)

### 3. Union-based SQL Injection
**Goal**: Extract information from other tables

**Payload**:
```sql
' UNION SELECT 1,2,3,4,5,6,7,8 FROM users --
```

### 4. Blind SQL Injection
**Goal**: Extract data through true/false conditions

**Payload**:
```sql
' AND (SELECT COUNT(*) FROM users WHERE username='admin' AND SUBSTRING(password,1,1)='a')>0 --
```

## Database Schema

### Users Table
- `id` - Primary key
- `username` - Login username
- `password` - Login password (plain text for demonstration)
- `full_name` - User's full name
- `email` - Email address
- `role` - User role (admin/student)
- `created_at` - Account creation time

### Other Tables
- `user_sessions` - Login session tracking
- `audit_log` - Activity logging

## Attack Walkthrough

### Step 1: Enumerate Valid Users
Try common usernames like `admin`, `administrator`, `teacher`, etc.

### Step 2: Test SQL Injection
Attempt SQL injection payloads to bypass authentication:

```sql
' OR '1'='1
' OR 'x'='x
admin' --
' OR 1=1 #
```

### Step 3: Access Dashboard
Once logged in, view the dashboard to see all registered users and identify the administrator.

### Step 4: Advanced Exploitation
Try more sophisticated payloads to extract additional information.

## Defense Strategies

### 1. Input Validation
- Validate and sanitize all user input
- Use whitelist-based validation
- Reject special characters in authentication fields

### 2. Prepared Statements
- Use parameterized queries instead of string concatenation
```php
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
$stmt->bind_param("ss", $username, $password);
```

### 3. Password Hashing
- Never store passwords in plain text
- Use strong hashing algorithms (bcrypt, Argon2)
- Implement proper password policies

### 4. Error Handling
- Don't expose database errors to users
- Implement generic error messages
- Log security events

### 5. Principle of Least Privilege
- Use limited database accounts for web applications
- Implement proper access controls
- Regular security audits

## Educational Purpose
This lab is designed for authorized security testing and education only. Do not use these techniques on unauthorized systems.

## Learning Objectives
- Understand SQL Injection vulnerabilities
- Practice authentication bypass techniques
- Learn about secure coding practices
- Explore defense mechanisms against SQLi attacks