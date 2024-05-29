<!--
<!DOCTYPE html>
<html>
<head>
    <title>Document</title>
</head>

<body>
    <h3>Sign Up</h3>

    <form action="includes/formhandler.inc.php" method="post">
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="pwd"placeholder="Password">
        <button>Sign Up</button>
    </form>
</body>
</html>
-->




<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="../LoginPage/style.css">
    <link rel ="stylesheet" href="../LoginPage/light-mode.css">
</head>

<main>
    <form action="includes/formhandler.inc.php" method="post">
        <form id="registerForm" action="../LoginPage/login.html" method="post">
            <h1>Register</h1>
            <div>
                <label for="username">Username:</label>
                <input type="text" placeholder="Enter Username" name="username" id="email" required>
            </div>

            <div>
                <label for="pwd">Password:</label>
                <input type="password" placeholder="Enter Password:" name="pwd" id="pwd" required>
                <label for="pwd2">Re-enter Password:</label>
                <input type="password" placeholder="Re-enter Password:" name="pwd2" id="pwd2" required>
            </div>
            <div id="error-message" style="color:red; display:none;">Passwords do not match!</div>
            <section>
                <button type="button" id="registerButton" ><a href="../RecipeCode/index.php">Create</a></button>
                <p>Already have an account? <a href="../LoginPage/login.html">Sign in</a>.</p>
            </section>
            <button id="lightModeToggle" class="btn">Light Mode</button>
        </form>
    </form>
</main>
<script src="../LginPage/script.js"></script>
</html>
