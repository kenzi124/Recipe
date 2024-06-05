<?php
include_once '../RecipeCode/config.php';

//Create table
function createUserTable($pdo) {
    $pdo->exec("CREATE TABLE users (
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
    
}

function storeUserData($pdo, $userData) {
    try {
        $stmt = $pdo->prepare("INSERT INTO users (")
    }
}

?>