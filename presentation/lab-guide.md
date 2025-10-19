# COSMOS Security Labs Guide
## Your Mission: Find & Understand Web Vulnerabilities

### Getting Started

1. **Access the Dashboard**: `http://localhost:8080`
2. **Choose Your Lab**: Click on any security challenge
3. **Read the Instructions**: Each lab has guidance inside
4. **Document Your Findings**: Take notes on what you discover

---

## Lab 1: XSS Lab (Port 8082)
### Theme: News Platform with Comment System

#### Your Mission:
Find and exploit Cross-Site Scripting vulnerabilities in the comment system.

#### What to Look For:
- **Comment Input**: Try submitting JavaScript in comments
- **Article Search**: Test search functionality with XSS payloads
- **Profile Fields**: If there's a user profile, test all text fields

#### XSS Payloads to Try:
```html
<script>alert('XSS')</script>
<img src=x onerror=alert('XSS')>
"><script>alert('XSS')</script>
```

#### Learning Objectives:
- Understand how XSS executes in browsers
- Learn difference between stored and reflected XSS
- See real impact of script injection

#### Questions to Answer:
- Where does your XSS execute?
- Who can see the malicious script?
- What damage could this cause in real life?

---

## Lab 2: SQLi Lab (Port 8083)
### Theme: Classroom Management System

#### Your Mission:
Bypass authentication and extract student data using SQL Injection.

#### What to Look For:
- **Login Form**: Try SQLi bypass techniques
- **Search Functions**: Test for union-based injection
- **ID Parameters**: Try manipulating numeric parameters

#### SQLi Payloads to Try:
```sql
' OR '1'='1' --
' UNION SELECT username,password FROM users --
1' OR '1'='1' --
```

#### Learning Objectives:
- Understand how SQL queries are constructed
- See impact of database breaches
- Learn importance of prepared statements

#### Questions to Answer:
- What information can you extract?
- How could attackers use this data?
- How would you prevent this?

---

## Lab 3: LFI Lab (Port 8081)
### Theme: Corporate Website

#### Your Mission:
Exploit Local File Inclusion to read sensitive files.

#### What to Look For:
- **URL Parameters**: Look for `?page=` or `?file=` parameters
- **Include Functions**: Test different file paths
- **Directory Traversal**: Use `../` to move up directories

#### LFI Payloads to Try:
```
?page=../../../../etc/passwd
?page=../../../../var/www/html/config.php
?file=../../../../etc/hosts
```

#### Learning Objectives:
- Understand file system access vulnerabilities
- Learn about path traversal attacks
- See impact of configuration file exposure

#### Questions to Answer:
- What files can you read?
- What sensitive information is exposed?
- How would you secure file includes?

---

## Lab 4: JWT Lab (Port 8084)
### Theme: Enterprise Application

#### Your Mission:
Manipulate JWT tokens to gain unauthorized access.

#### What to Look For:
- **Login Tokens**: Capture and analyze JWT after login
- **Token Structure**: Decode JWT to see contents
- **Algorithm Manipulation**: Try changing algorithm to "none"

#### JWT Manipulation Steps:
1. **Login normally** to get a valid token
2. **Decode the token** using jwt.io or similar tool
3. **Modify claims** (like changing role to "admin")
4. **Change algorithm** to "none" if possible
5. **Use modified token** to access protected areas

#### Learning Objectives:
- Understand JWT structure and components
- Learn about token-based authentication
- See impact of token manipulation

#### Questions to Answer:
- What happens when you modify the token?
- How does the server validate JWTs?
- What makes JWTs secure or insecure?

---

## General Tips for All Labs

### Exploration Approach:
1. **Start Simple**: Try basic inputs first
2. **Read Error Messages**: They often give hints
3. **Use Developer Tools**: Check network requests and console
4. **Think Like an Attacker**: What would you try to break?

### Documentation:
- **Screenshot Your Findings**: Capture proof of vulnerabilities
- **Note the Payloads**: Write down what worked
- **Describe the Impact**: Explain why this matters
- **Think of Fixes**: How would you prevent this?

### Safe & Ethical Hacking:
- ✅ **These are legal environments** designed for learning
- ✅ **Document everything** you discover
- ✅ **Think about defense** as much as offense
- ❌ **Don't apply these techniques** to real websites without permission

### Stuck? Try These Hints:

#### XSS Lab Hints:
- Look at the HTML source - where does your input appear?
- Try different contexts: HTML attributes, JavaScript, URLs
- Check if there are any filters you can bypass

#### SQLi Lab Hints:
- Start with the login form - it's often the easiest target
- Try error-based injection first
- Look for numeric parameters in URLs

#### LFI Lab Hints:
- Check the URL for file or page parameters
- Try different file extensions (.php, .txt, .html)
- Look for configuration files in common locations

#### JWT Lab Hints:
- Use browser dev tools to capture authentication tokens
- Try jwt.io to decode and modify tokens
- Test different algorithm values

---

## Debrief Questions

After completing the labs, discuss:

### Technical Understanding:
- Which vulnerability was easiest to exploit? Why?
- Which was most difficult? What made it challenging?
- How do these vulnerabilities relate to each other?

### Real-World Impact:
- How would these vulnerabilities affect a real business?
- What kind of data would be most valuable to attackers?
- How would you prioritize fixing these issues?

### Prevention Strategies:
- What coding practices would prevent each vulnerability?
- How can developers test for these issues?
- What tools help catch these problems?

### Personal Reflection:
- What surprised you most about these vulnerabilities?
- How will this change how you write code?
- What security topics do you want to learn more about?

---

## Getting Help

### During the Lab:
- **Ask Questions**: The instructor is here to help!
- **Work Together**: Discuss approaches with classmates
- **Use Resources**: Refer back to the presentation slides

### After the Lab:
- **Practice More**: Try PortSwigger Web Security Academy
- **Read More**: OWASP Top 10 and security blogs
- **Build Securely**: Apply what you learned to your projects

### Further Learning:
- **PortSwigger Web Security Academy**: Free, online, hands-on training
- **OWASP Top 10**: Most critical web application security risks
- **Bug Bounty Programs**: Legal ways to practice security skills

Remember: The goal isn't just to "break" things - it's to understand how they break so you can build them better! 🚀