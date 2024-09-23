<?php
// Database connection configuration
$host = 'ixnzh1cxch6rtdrx.cbetxkdyhwsb.us-east-1.rds.amazonaws.com';  // Adjust if necessary
$dbname = 'tjmzqsfikd7skftg';  // Your database name
$username = 'ls4erapz4hg0t1fs';  // Your database username
$password = 'fddb6ge7gda6pzkb';  // Your database password

try {
    // Connect to the MySQL database using PDO with SSL disabled (if needed)
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, array(
        PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
    ));
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
