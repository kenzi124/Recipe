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

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="light-mode.css">
</head>

<body>
<main>
    <form action="login.php" method="post">
        <h1>Login</h1>
        <div>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
        </div>
        <br>
        <button type="submit">Login</button>
        <br>
        <a href="https://gifdb.com/images/high/that-s-crazy-damn-bro-0qrzc1wo0rpyzwq2.gif">Forgot your password?</a>
        <br>
        <br>
        <a href="register.php">Register</a>
        <br>
        <br>
        <button id="lightModeToggle" class="btn">Light Mode</button>
    </form>
    <script src="script.js"></script>
</main>
</body>

<?php view('footer'); ?>
