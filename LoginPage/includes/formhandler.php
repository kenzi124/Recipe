<?php

function checkUser() {
    if (isset($_POST["login"])) {
        $username = $_POST["username"];
        $pwd = $_POST["pwd"];
         require_once "config.php";
         $sql = "SELECT * FROM users WHERE username = '$username'";
         $result = mysqli_query($conn, $sql);
         $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
         if ($user) {
             if (password_verify($pwd, $user["password"])) {
                 session_start();
                 $_SESSION["user"] = "yes";
                 header("Location: ../Homepage/home.php");
                 die();
             }else{
                 echo "<div class='alert alert-danger'>Password does not match</div>";
             }
         }else{
             echo "<div class='alert alert-danger'>Username does not match</div>";
         }
    }
}

function storeUser() {
    if (isset($_POST["submit"])) {
        $username = $_POST["username"];
        $pwd = $_POST["pwd"];
        $repeatpwd = $_POST["pwd2"];
        
        $passwordHash = password_hash($pwd, PASSWORD_DEFAULT);

        $errors = array();
        
        if (empty($username) OR empty($pwd) OR empty($repeatpwd)) {
            array_push($errors, "All fields are required!");
        }
        if ($pwd !== $repeatpwd) {
            array_push($errors, "Password does not match!");
        }

        require_once "config.php";
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) > 0) {
                array_push($errors, "Username already taken!");
            }
        } else {
            array_push($errors, "Error checking username availability!");
        }

        if (count($errors) > 0) {
            foreach ($errors as $error) {
                echo "<div class='alert alert-danger' style='color:red;'>$error</div>";
            }
        } else {
            $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
            $stmt = mysqli_stmt_init($conn);
            if (mysqli_stmt_prepare($stmt, $sql)) {
                mysqli_stmt_bind_param($stmt, "ss", $username, $passwordHash);
                mysqli_stmt_execute($stmt);
                echo "<div class='alert alert-success'>You are registered successfully.</div>";
            } else {
                die("Something went wrong");
            }
        }
    }
}
?>
