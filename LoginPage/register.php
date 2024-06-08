<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(isset($_SESSION["user"])) {
    header("Location: RecipeIngredients.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
    <link rel ="stylesheet" href="light-mode.css">
</head>
<body>
    <div class="container">
        <?php
        if(isset($_POST["submit"])) {
            include 'includes/formhandler.php';
            storeUser();
        }
        ?>
        <form id="registerForm" action="register.php" method="post">
            <h1>Register</h1>
            <div>
                <label for="username">Username:</label>
                <input type="text" placeholder="Enter Username" name="username" id="username" required>
            </div>

            <div>
                <label for="pwd">Password:</label>
                <input type="password" placeholder="Enter Password" name="pwd" required>
                <label for="pwd2">Re-enter Password:</label>
                <input type="password" placeholder="Re-enter Password" name="pwd2" required>
            </div>

            <section>
                <input type="submit" value="Create" name="submit">
                <p>Already have an account? <a href="login.php">Sign in</a>.</p>
            </section>
            <button id="lightModeToggle" class="btn">Light Mode</button>
        </form>
    </div>
<script src="script.js"></script>
</body>
</html>
