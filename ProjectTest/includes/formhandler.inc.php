<?php 
include_once 'config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];

    try{
  // Ensure this matches the actual file name
        
        // Use named placeholders in the SQL query

        $stmt = $pdo->prepare("INSERT INTO users (username, pwd) VALUES (:username, :pwd)");

        // Bind the parameters to the placeholders
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":pwd", $pwd);

        $stmt->execute();

        echo "Store data successfully.";
        die();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
}
?>
