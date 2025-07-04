<?php
require_once 'config/db.php';

try {
    // Create users table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            matric_number VARCHAR(50),
            department VARCHAR(100),
            institution VARCHAR(100),
            password_hash VARCHAR(255) NOT NULL,
            role ENUM('student', 'supervisor', 'admin') NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");
    
    // Create log_entries table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS log_entries (
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
        )
    ");
    
    // Insert sample admin user
    $adminPassword = password_hash('admin123', PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("
        INSERT IGNORE INTO users (name, email, department, institution, password_hash, role) 
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute(['SIWES Coordinator', 'admin@siwes.com', 'Computer Science', 'University', $adminPassword, 'admin']);
    
    // Insert sample supervisor
    $supervisorPassword = password_hash('supervisor123', PASSWORD_DEFAULT);
    $stmt->execute(['John Supervisor', 'supervisor@company.com', 'Computer Science', 'Tech Company', $supervisorPassword, 'supervisor']);
    
    // Insert sample student
    $studentPassword = password_hash('student123', PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("
        INSERT IGNORE INTO users (name, email, matric_number, department, institution, password_hash, role) 
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute(['Alice Student', 'alice@student.com', '2021001', 'Computer Science', 'University', $studentPassword, 'student']);
    
    echo "Database setup completed successfully!\n";
    echo "Sample users created:\n";
    echo "Admin: admin@siwes.com / admin123\n";
    echo "Supervisor: supervisor@company.com / supervisor123\n";
    echo "Student: alice@student.com / student123\n";
    
} catch (PDOException $e) {
    echo "Database setup failed: " . $e->getMessage() . "\n";
}
?> 