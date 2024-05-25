<?php
require __DIR__ . '/../src/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Include database connection
    $conn = new mysqli('localhost', 'username', 'password', 'testdb');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve and sanitize form data
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['pwd'];
    $password2 = $_POST['pwd2'];

    // Check if passwords match
    if ($password !== $password2) {
        echo "Passwords do not match!";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert user into database
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $hashed_password);

        if ($stmt->execute()) {
            echo "Registration successful! <a href='login.php'>Login here</a>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $conn->close();
}
?>

<?php view('header', ['title' => 'Register']) ?>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
    <link rel ="stylesheet" href="light-mode.css">
</head>
<main>
    <form action="register.php" method="post">
        <h1>Register</h1>
        <div>
            <label for="email">Email:</label>
            <input type="email" placeholder="Enter Email" name="email" id="email" required>
        </div>
        <div>
            <label for="pwd">Password:</label>
            <input type="password" placeholder="Enter Password" name="pwd" id="pwd" required>
            <label for="pwd2">Re-enter Password:</label>
            <input type="password" placeholder="Re-enter Password" name="pwd2" id="pwd2" required>
        </div>
        <section>
            <button type="submit">Create</button>
            <p>Already have an account? <a href="login.php">Sign in</a>.</p>
        </section>
    </form>
</main>
<?php view('footer') ?>
