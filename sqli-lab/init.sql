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
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Professor Cosmos', 'cosmos@cosmosapps.edu', 'admin');

INSERT INTO users (username, password, full_name, email, role) VALUES
('s.martinez', '$2y$10$lkBZ3j0Jz3MDE73hT/emt.JCkXDmrL9ja6cbWWHnYMZ1j1///cyb6', 'Sofia Martinez', 's.martinez@cosmosapps.edu', 'student'),
('j.chen', '$2y$10$4DRehVrwiUJgRxTz.oucP.KTuTWYWt5YfCga/KBoAfSQaId0zyn76', 'Jason Chen', 'j.chen@cosmosapps.edu', 'student'),
('r.williams', '$2y$10$NTlVRfO.P0LIdOYTwad9Su3e0RIZYo1bRYAKPFqhvYmSTohdFHdk2', 'Rachel Williams', 'r.williams@cosmosapps.edu', 'student'),
('m.anderson', '$2y$10$jM7xoOf2YyDZOb9KOpAaIezcBgPhd7fLScm5Hza/UUQxtkJMLC3yi', 'Marcus Anderson', 'm.anderson@cosmosapps.edu', 'student'),
('e.thompson', '$2y$10$z8inaKeW/3r0eScK4dKoMO4nGfDO/IXP6S8G0iVYNjZXGAr7/39zK', 'Emma Thompson', 'e.thompson@cosmosapps.edu', 'student'),
('d.rodriguez', '$2y$10$w5IImMjlej424nSLUDEmZu0cn2XGHyu.EKXy6krxsPaO7LOvEE0QS', 'Daniel Rodriguez', 'd.rodriguez@cosmosapps.edu', 'student'),
('k.patel', '$2y$10$pH6yHLV57taWHZkDsyVb7evYfhxIOlvtA67.e4g8YRo5zA516TjxG', 'Kavya Patel', 'k.patel@cosmosapps.edu', 'student'),
('l.johnson', '$2y$10$.gpMwHvFCV9gVs98HtGgPulqGjCLHzuTzFR7R9bhR/KdDynYes7fK', 'Liam Johnson', 'l.johnson@cosmosapps.edu', 'student');

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