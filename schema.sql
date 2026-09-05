CREATE DATABASE IF NOT EXISTS user_system;
USE user_system;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('Admin', 'Regular User') DEFAULT 'Regular User'
);

INSERT INTO users (name, email, password, role) VALUES 
('Alice Admin', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.RAW7d4y2q', 'Admin'),
('Bob User', 'user@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.RAW7d4y2q', 'Regular User')
ON DUPLICATE KEY UPDATE name=VALUES(name);