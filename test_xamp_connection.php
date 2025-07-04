<?php
echo "=== XAMP Connection Test ===\n\n";

// Test PHP version
echo "1. PHP Version: " . phpversion() . "\n";

// Test MySQL extension
if (extension_loaded('pdo_mysql')) {
    echo "2. PDO MySQL Extension: ✓ Loaded\n";
} else {
    echo "2. PDO MySQL Extension: ✗ Not loaded\n";
}

// Test database connection
try {
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    echo "3. MySQL Connection: ✓ Success\n";
    
    // Test database creation
    $pdo->exec("CREATE DATABASE IF NOT EXISTS test_siwes");
    echo "4. Database Creation: ✓ Success\n";
    
    // Test table creation
    $pdo->exec("USE test_siwes");
    $pdo->exec("CREATE TABLE IF NOT EXISTS test_table (id INT)");
    echo "5. Table Creation: ✓ Success\n";
    
    // Clean up
    $pdo->exec("DROP DATABASE test_siwes");
    echo "6. Cleanup: ✓ Success\n";
    
    echo "\n=== All Tests Passed! ===\n";
    echo "Your XAMP setup is working correctly.\n";
    
} catch (PDOException $e) {
    echo "3. MySQL Connection: ✗ Failed\n";
    echo "Error: " . $e->getMessage() . "\n";
    echo "\nTroubleshooting Tips:\n";
    echo "- Make sure XAMP MySQL service is running\n";
    echo "- Check if MySQL is running on port 3306\n";
    echo "- Verify root password is empty (default XAMP setting)\n";
}
?> 