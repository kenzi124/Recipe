<?php 
$dsn = "mysql:unix_socket=C:/xampp/mysql/mysql.sock;dbname=DatabaseTable";
$dbusername = "root";
$dbpassword = "";

try {
    // Database object 
    $pdo = new PDO($dsn, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connection successful!<br>";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>