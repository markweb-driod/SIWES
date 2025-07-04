-- SIWES Database Schema
-- Student Industrial Work Experience Scheme

-- Create database if not exists
CREATE DATABASE IF NOT EXISTS siwes_db;
USE siwes_db;

-- Drop tables if they exist (for clean setup)
DROP TABLE IF EXISTS log_entries;
DROP TABLE IF EXISTS users;

-- Create users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    matric_number VARCHAR(50),
    department VARCHAR(100),
    institution VARCHAR(100),
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('student', 'supervisor', 'admin') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create log_entries table
CREATE TABLE log_entries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    activity TEXT NOT NULL,
    date DATE NOT NULL,
    latitude VARCHAR(50),
    longitude VARCHAR(50),
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    supervisor_comment TEXT,
    supervisor_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (supervisor_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Insert sample admin user
INSERT INTO users (name, email, department, institution, password_hash, role) 
VALUES ('SIWES Coordinator', 'admin@siwes.com', 'Computer Science', 'University', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Insert sample supervisor
INSERT INTO users (name, email, department, institution, password_hash, role) 
VALUES ('John Supervisor', 'supervisor@company.com', 'Computer Science', 'Tech Company', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'supervisor');

-- Insert sample student
INSERT INTO users (name, email, matric_number, department, institution, password_hash, role) 
VALUES ('Alice Student', 'alice@student.com', '2021001', 'Computer Science', 'University', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student');

-- Insert sample log entries
INSERT INTO log_entries (student_id, activity, date, latitude, longitude, status) 
VALUES 
(3, 'Completed web development training session', '2024-01-15', '6.5244', '3.3792', 'approved'),
(3, 'Worked on database design and implementation', '2024-01-16', '6.5244', '3.3792', 'pending'),
(3, 'Attended team meeting and project planning', '2024-01-17', '6.5244', '3.3792', 'approved');

-- Update log entries with supervisor
UPDATE log_entries SET supervisor_id = 2, supervisor_comment = 'Good work on the web development training. Keep it up!' WHERE id = 1;
UPDATE log_entries SET supervisor_comment = 'Excellent database work. Well structured and efficient.' WHERE id = 3;

-- Show created tables
SHOW TABLES;

-- Show sample data
SELECT 'Users Table:' as info;
SELECT id, name, email, role, created_at FROM users;

SELECT 'Log Entries Table:' as info;
SELECT id, student_id, activity, date, status, supervisor_id FROM log_entries; 