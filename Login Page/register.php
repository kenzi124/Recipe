<?php
require __DIR__ . '/../src/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['pwd'];
    $password_confirm = $_POST['pwd2'];

    if ($password !== $password_confirm) {
        $error_message = "Passwords do not match.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email, $hashed_password]);

        header("Location: login.php");
        exit();
    }
}

view('header', ['title' => 'Register']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="light-mode.css">
</head>
<body>
<main>
    <form action="login.php" method="post">
        <h1>Register</h1>
        <br>
        <div>
            <label for="email">Username:</label>
            <input type="text" placeholder="Enter Username" name="email" id="email" required>
        </div>
        <br>
        <div>
            <label for="pwd">Password:</label>
            <input type="password" placeholder="Enter Password:" name="pwd" id="pwd" required>
        </div>
        <div>
            <label for="pwd2">Re-enter Password:</label>
            <input type="password" placeholder="Re-enter Password:" name="pwd2" id="pwd2" required>
        </div>
        <br>
        <section>
            <button onclick="window.location.href='login.php'">Create</button>
            <p>Already have an account? <a href="login.php">Sign in</a>.</p>
        </section>
        <button id="lightModeToggle" class="btn">Light Mode</button>
    </form>
    <script src="script.js"></script>
</main>
</body>

</html>

<?php view('footer'); ?>
