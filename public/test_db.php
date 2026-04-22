<?php
/**
 * Database Connection Diagnostic Script
 * Upload this to your public_html folder and visit yourdomain.com/test_db.php
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../config/config.php';

echo "<h1>Database Connection Diagnostic</h1>";
echo "<p><strong>Attempting to connect with:</strong></p>";
echo "<ul>";
echo "<li>Host: " . DB_HOST . "</li>";
echo "<li>Database: " . DB_NAME . "</li>";
echo "<li>Username: " . DB_USER . "</li>";
echo "<li>Charset: " . DB_CHARSET . "</li>";
echo "</ul>";

try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    
    echo "<h2 style='color: green;'>✅ Success! Connection established.</h2>";
    
    // Check if tables exist
    $query = $pdo->query("SHOW TABLES");
    $tables = $query->fetchAll(PDO::FETCH_COLUMN);
    
    if (empty($tables)) {
        echo "<p style='color: orange;'>⚠️ Connection successful, but <strong>no tables found</strong>. Did you import schema.sql?</p>";
    } else {
        echo "<p>Found " . count($tables) . " tables:</p><ul>";
        foreach ($tables as $table) {
            echo "<li>$table</li>";
        }
        echo "</ul>";
        
        // Check if admin user exists
        $admin = $pdo->query("SELECT COUNT(*) FROM admin_users")->fetchColumn();
        echo "<p>Admin users found: " . $admin . "</p>";
    }

} catch (PDOException $e) {
    echo "<h2 style='color: red;'>❌ Connection Failed</h2>";
    echo "<p><strong>Error Message:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>Error Code:</strong> " . $e->getCode() . "</p>";
    
    echo "<h3>Common Fixes:</h3>";
    echo "<ul>";
    echo "<li>Verify DB_USER and DB_PASS in <code>config/config.php</code></li>";
    echo "<li>Ensure DB_HOST is 'localhost' (most shared hosting use localhost)</li>";
    echo "<li>Make sure you created the database <strong>" . DB_NAME . "</strong> in your hosting panel</li>";
    echo "<li>Check if your hosting requires a prefix for DB/Usernames (e.g. <code>u12345_probe_journals</code>)</li>";
    echo "</ul>";
}
