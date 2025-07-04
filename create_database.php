<?php
// First, connect without specifying a database
$host = 'localhost';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    
    // Create the database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS siwes_db");
    echo "Database 'siwes_db' created successfully!\n";
    
    // Now run the setup script
    echo "Running database setup...\n";
    require_once 'backend/setup_database.php';
    
} catch (\PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?> 