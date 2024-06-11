<?php

$hostName = "localhost";
$dbUser = "root";
$dbPassword = "12345678";
$dbName = "cookbook";
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
if (!$conn) {
    die("Something went wrong;");
}

?>