# COSMOS Security Labs

A comprehensive suite of security laboratories designed for educational purposes and penetration testing practice. Each lab demonstrates specific vulnerabilities in realistic, production-like environments.

## Overview

The COSMOS Security Labs platform includes four distinct vulnerability laboratories:

- **JWT Lab**: Authentication bypass using weak JWT signing keys
- **SQLI Lab**: SQL injection vulnerabilities in a classroom management system
- **LFI Lab**: Local file inclusion vulnerabilities in a corporate website
- **XSS Lab**: Cross-site scripting vulnerabilities in a news platform

## Quick Start

```bash
# Start all labs
docker-compose up -d

# Access individual labs
# JWT Lab: http://localhost:8084
# SQLI Lab: http://localhost:8083
# LFI Lab: http://localhost:8081
# XSS Lab: http://localhost:8082
```

## Individual Labs

### JWT Security Lab - SICOSMOS

**Enterprise Information Management System with JWT Authentication**

- **URL**: http://localhost:8084
- **Vulnerability**: Weak JWT signing key
- **Technology**: Go with Gin framework, MySQL database
- **Description**: Professional enterprise system with role-based access control

**Vulnerability Details**:
- JWT tokens signed with weak secret key
- Authorization based on userID parameter (admin = userID 1)
- Users can forge admin tokens by exploiting weak signing

**Note**: Initial credentials are randomized for security testing. Credentials must be discovered through legitimate testing methods.

### SQL Injection Lab - COSMOS Apps

**Classroom Management System**

- **URL**: http://localhost:8083
- **Vulnerability**: SQL injection in authentication
- **Technology**: PHP, MySQL database
- **Description**: Educational platform with student and administrator roles

**Vulnerability Details**:
- Direct SQL query construction with user input
- Authentication bypass possible through crafted queries
- Database contains sensitive user information

**Note**: Credentials are randomized. Test authentication mechanisms to identify valid access patterns.

### Local File Inclusion Lab - CosmosCorp

**Enterprise Technology Solutions Website**

- **URL**: http://localhost:8081
- **Vulnerability**: Path traversal and local file inclusion
- **Technology**: PHP
- **Description**: Corporate website with dynamic content loading

**Vulnerability Details**:
- File inclusion via unsanitized user input
- Path traversal to access system files
- Potential for sensitive file exposure

### Cross-Site Scripting Lab - CosmosNews

**Technology News Platform**

- **URL**: http://localhost:8082
- **Vulnerability**: Stored and reflected XSS
- **Technology**: PHP, MySQL database
- **Description**: News platform with user-submitted content

**Vulnerability Details**:
- Unsanitized user input in article content
- Reflected XSS in search functionality
- Stored XSS in comment systems

## Security Notes

### Credential Management
- All labs use randomized credentials
- Default credentials are intentionally not provided
- Testing requires legitimate security assessment techniques
- Password discovery is part of the security challenge

### Authorization Logic
Each lab implements different authorization mechanisms:
- **JWT Lab**: userID-based access (userID 1 = admin)
- **SQLI Lab**: Role-based access (admin/student)
- **LFI Lab**: File system access through path manipulation
- **XSS Lab**: Content-based privileges

### Database Schemas

#### JWT Lab (MySQL)
```sql
users table: id, username, password, email, full_name, role, created_at, updated_at, last_login
- Admin: Always userID 1
- Regular users: userID 2, 3, 4, etc.
```

#### SQLI Lab (MySQL)
```sql
users table: id, username, password, role, email
audit_log table: id, user_id, action, description, ip_address, timestamp
```

#### XSS Lab (MySQL)
```sql
news_articles table: id, title, content, author, category, created_at
```

## Technologies Used

- **Backend**: Go (JWT Lab), PHP (SQLI, LFI, XSS Labs)
- **Databases**: MySQL 8.0
- **Frontend**: HTML5, CSS3, Tailwind CSS, Vanilla JavaScript
- **Containerization**: Docker with docker-compose
- **Web Servers**: Apache (LFI, XSS), Nginx/Gin (JWT, SQLI)

## Exploitation Guidelines

### Legal and Ethical Usage
- Use only for authorized security testing
- Do not attempt to compromise systems outside the lab environment
- Follow responsible disclosure practices
- Educational purposes only

### Testing Approach
1. **Reconnaissance**: Identify application functionality
2. **Vulnerability Discovery**: Test for specific weakness patterns
3. **Exploitation**: Develop proof-of-concept exploits
4. **Documentation**: Record findings and impact assessment

### Common Attack Vectors
- **Weak Authentication**: Credential brute force, JWT manipulation
- **Injection Attacks**: SQL injection, command injection
- **File Inclusion**: Path traversal, LFI/RFI
- **Client-Side Attacks**: XSS, CSRF, DOM-based attacks

## Learning Objectives

After completing these labs, security professionals should understand:

- **Authentication Bypass**: Weak JWT implementation exploitation
- **SQL Injection**: Query manipulation and data extraction
- **File Inclusion**: Path traversal and system access
- **Cross-Site Scripting**: Client-side script injection and impact

## Mitigation Strategies

Each lab demonstrates security failures that can be mitigated by:

### JWT Security
- Use strong, randomly generated signing keys
- Implement asymmetric algorithms (RS256)
- Server-side role validation
- Short token expiration times

### SQL Injection Prevention
- Parameterized queries/prepared statements
- Input validation and sanitization
- Least privilege database access
- Regular security audits

### File Inclusion Prevention
- Whitelist allowed files/directories
- Input validation and sanitization
- Secure file permissions
- Avoid direct user input in file paths

### XSS Prevention
- Output encoding and escaping
- Content Security Policy (CSP)
- Input validation
- HTTP-only cookies

## Contributing

This is an educational security platform. Contributions should focus on:
- Improving realism while maintaining educational value
- Adding new vulnerability patterns
- Enhancing documentation
- Fixing deployment issues

## License

Educational use only. See individual lab licenses for specific terms.

---

**Disclaimer**: These laboratories are designed for authorized security testing and educational purposes only. Unauthorized access to computer systems is illegal and unethical.