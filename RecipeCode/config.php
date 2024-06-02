<?php
$dsn = "mysql:unix_socket=/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock;dbname=DatabaseTable";
$dbusername = "root";
$dbpassword = "";

try {
    // Database object 
    $pdo = new PDO($dsn, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connection successful!<br>";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die("<br>Oops! Something went wrong. Please try again later.");
}
?>