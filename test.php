<?php
echo "<h1>SIWES Server Test</h1>";
echo "<p>✅ PHP is working correctly!</p>";
echo "<p>✅ Server can access your files!</p>";
echo "<p>Current directory: " . getcwd() . "</p>";
echo "<p>PHP version: " . phpversion() . "</p>";
echo "<p>Server time: " . date('Y-m-d H:i:s') . "</p>";

// Test database connection
try {
    require_once 'backend/config/db.php';
    echo "<p>✅ Database connection successful!</p>";
} catch (Exception $e) {
    echo "<p>❌ Database connection failed: " . $e->getMessage() . "</p>";
}

// List files in current directory
echo "<h2>Files in current directory:</h2>";
echo "<ul>";
$files = scandir('.');
foreach ($files as $file) {
    if ($file != '.' && $file != '..') {
        echo "<li>$file</li>";
    }
}
echo "</ul>";
?> 