<?php
// Quick database connection test
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'localhost';
$dbname = 'jobnest';
$username = 'root';
$password = '';

echo "<h2>JobNest Database Connection Test</h2>";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p style='color:green'>✓ Database connection successful!</p>";
    
    // Check tables
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "<p>Tables found: " . implode(', ', $tables) . "</p>";
    
    // Count records
    if (in_array('jobs', $tables)) {
        $jobCount = $pdo->query("SELECT COUNT(*) FROM jobs")->fetchColumn();
        echo "<p>Jobs: $jobCount</p>";
    }
    if (in_array('recruiters', $tables)) {
        $recCount = $pdo->query("SELECT COUNT(*) FROM recruiters")->fetchColumn();
        echo "<p>Recruiters: $recCount</p>";
    }
    
    echo "<p style='color:green'>✓ All good! Your app should work.</p>";
    
} catch(PDOException $e) {
    echo "<p style='color:red'>✗ Connection failed: " . $e->getMessage() . "</p>";
    echo "<h3>To fix this:</h3>";
    echo "<ol>";
    echo "<li>Make sure MySQL is running in XAMPP Control Panel</li>";
    echo "<li>Go to <a href='http://localhost/phpmyadmin'>phpMyAdmin</a></li>";
    echo "<li>Click 'Import' and select database.sql</li>";
    echo "<li>Click 'Go' to import</li>";
    echo "</ol>";
}
?>
