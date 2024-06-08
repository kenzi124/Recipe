<?php
session_start();
if(isset($_SESSION["user"])) {
    header("Location: ../Homepage/home.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../LoginPage/style.css">
    <link rel ="stylesheet" href="../LoginPage/light-mode.css">
</head>

<body>
<main class="form-container">
    <?php 
    if(isset($_POST["login"])) {
        include 'includes/formhandler.inc.php';
        checkUser();
    }
    ?>
    <form action="login.php" method="post">
        <h1>Login</h1>
        <div>
            <label for="username">Username:</label>
            <input type="text" placeholder="Enter Username:" name="username" required>
        </div>
        <div>
            <label for="pwd">Password:</label>
            <input type="password" placeholder="Enter Password:" name="pwd" required>
        </div>
        <br>
        <button type="submit" value="Login" name="login">Login</button>
        <br>
        <a href="https://gifdb.com/images/high/that-s-crazy-damn-bro-0qrzc1wo0rpyzwq2.gif">Forgot your password?</a>
        <br>
        <br>
        <a href="../ProjectTest/register.php">Register</a>
        <br>
        <br>
        <button id="lightModeToggle" class="btn">Light Mode</button>
    </form>
    <script src="script.js"></script>
</main>
</body>

</html>
