CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    role ENUM('admin', 'student') NOT NULL DEFAULT 'student',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO users (username, password, full_name, email, role) VALUES
('admin', 'admin123', 'Professor Cosmos', 'cosmos@cosmosapps.edu', 'admin');

INSERT INTO users (username, password, full_name, email, role) VALUES
('s.martinez', 'student123', 'Sofia Martinez', 's.martinez@cosmosapps.edu', 'student'),
('j.chen', 'student123', 'Jason Chen', 'j.chen@cosmosapps.edu', 'student'),
('r.williams', 'student123', 'Rachel Williams', 'r.williams@cosmosapps.edu', 'student'),
('m.anderson', 'student123', 'Marcus Anderson', 'm.anderson@cosmosapps.edu', 'student'),
('e.thompson', 'student123', 'Emma Thompson', 'e.thompson@cosmosapps.edu', 'student'),
('d.rodriguez', 'student123', 'Daniel Rodriguez', 'd.rodriguez@cosmosapps.edu', 'student'),
('k.patel', 'student123', 'Kavya Patel', 'k.patel@cosmosapps.edu', 'student'),
('l.johnson', 'student123', 'Liam Johnson', 'l.johnson@cosmosapps.edu', 'student');

CREATE TABLE IF NOT EXISTS user_sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    session_token VARCHAR(255) NOT NULL,
    login_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_activity TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS audit_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    action VARCHAR(100) NOT NULL,
    description TEXT,
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);