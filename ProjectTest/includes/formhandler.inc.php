<?php 

echo '<a href="http://localhost/phpmyadmin" target="blank">Manage database with phpmyadmin</a><br>';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];

    try {
        require_once "pdo-conn.php";  // Ensure this matches the actual file name
        
        // Use named placeholders in the SQL query
        $query = "INSERT INTO users (username, pwd) VALUES (:username, :pwd)";

        $stmt = $pdo->prepare($query);

        // Bind the parameters to the placeholders
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":pwd", $pwd);

        $stmt->execute();

        // Close the database connections
        $pdo = null;
        $stmt = null;

        // Redirect to the registration page
        header("Location: ../register.php");
        die();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../register.php");
}
?>
