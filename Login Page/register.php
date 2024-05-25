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
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="light-mode.css">
</head>

<main>
    <form action="register.php" method="post">
        <h1>Register</h1>
        <div>
            <label for="email">Email:</label>
            <input type="text" placeholder="Enter Email" name="email" id="email" required>
        </div>

        <div>
            <label for="pwd">Password:</label>
            <input type="password" placeholder="Enter Password:" name="pwd" id="pwd" required>
            <label for="pwd2">Re-enter Password:</label>
            <input type="password" placeholder="Re-enter Password:" name="pwd2" id="pwd2" required>
        </div>

        <?php if (isset($error_message)) : ?>
            <p style="color: red;"><?= $error_message ?></p>
        <?php endif; ?>

        <section>
            <button type="submit">Create</button>
            <p>Already have an account? <a href="login.html">Sign in</a>.</p>
        </section>
    </form>
</main>

<?php view('footer'); ?>
