<?php
require_once 'backend/config/db.php';

try {
    echo "=== SIWES Database Verification ===\n\n";
    
    // Show tables
    echo "1. Database Tables:\n";
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll();
    foreach ($tables as $table) {
        echo "   - " . $table[array_keys($table)[0]] . "\n";
    }
    
    echo "\n2. Users Table Structure:\n";
    $stmt = $pdo->query("DESCRIBE users");
    $columns = $stmt->fetchAll();
    foreach ($columns as $column) {
        echo "   - " . $column['Field'] . " (" . $column['Type'] . ")\n";
    }
    
    echo "\n3. Log Entries Table Structure:\n";
    $stmt = $pdo->query("DESCRIBE log_entries");
    $columns = $stmt->fetchAll();
    foreach ($columns as $column) {
        echo "   - " . $column['Field'] . " (" . $column['Type'] . ")\n";
    }
    
    echo "\n4. Sample Users:\n";
    $stmt = $pdo->query("SELECT id, name, email, role FROM users");
    $users = $stmt->fetchAll();
    foreach ($users as $user) {
        echo "   - ID: " . $user['id'] . ", Name: " . $user['name'] . ", Email: " . $user['email'] . ", Role: " . $user['role'] . "\n";
    }
    
    echo "\n5. Sample Log Entries:\n";
    $stmt = $pdo->query("SELECT id, student_id, activity, date, status FROM log_entries LIMIT 5");
    $entries = $stmt->fetchAll();
    foreach ($entries as $entry) {
        echo "   - ID: " . $entry['id'] . ", Student ID: " . $entry['student_id'] . ", Activity: " . substr($entry['activity'], 0, 50) . "...\n";
    }
    
    echo "\n=== Database Setup Complete! ===\n";
    echo "You can now access the SIWES application.\n";
    echo "Default login credentials:\n";
    echo "- Admin: admin@siwes.com / admin123\n";
    echo "- Supervisor: supervisor@company.com / supervisor123\n";
    echo "- Student: alice@student.com / student123\n";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?> 