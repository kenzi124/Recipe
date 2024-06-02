<?php
include_once 'config.php';

// Create tables
function createCategoriesTable($pdo) {
    $pdo->exec("CREATE TABLE IF NOT EXISTS categories (
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        ingredient VARCHAR(50) NOT NULL UNIQUE,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
}

function storeCategoriesInDB($pdo, $categories) {
    try {
        $stmt = $pdo->prepare("INSERT INTO categories (ingredient) VALUES (:name)");
        foreach($categories as $cat) {
            $stmt->bindParam(':name', $cat);
            $stmt->execute();
        }

        echo "Categories stored in the database successfully!<br>";
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function createRecipeTables($pdo) {
    $pdo->exec("CREATE TABLE IF NOT EXISTS recipes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS ingredients (
        id INT AUTO_INCREMENT PRIMARY KEY,
        ingredient VARCHAR(100) NOT NULL
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS recipe_ingredients (
        recipe_id INT,
        ingredient_id INT,
        FOREIGN KEY (recipe_id) REFERENCES recipes(id),
        FOREIGN KEY (ingredient_id) REFERENCES ingredients(id),
        PRIMARY KEY (recipe_id, ingredient_id)
    )");
}

function insertRecipeWithIngredients($pdo, $recipeName, $ingredients) {
    $pdo->beginTransaction();

    try {
        // Insert recipe
        $stmt = $pdo->prepare("INSERT INTO recipes (name) VALUES (:name)");
        $stmt->bindParam(':name', $recipeName);
        $stmt->execute();
        $recipeId = $pdo->lastInsertId();

        // Insert ingredients and mapping
        foreach ($ingredients as $ingredientName) {
            $stmt = $pdo->prepare("INSERT INTO ingredients (ingredient) VALUES (:ingredient) ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id)");
            $stmt->bindParam(':ingredient', $ingredientName);
            $stmt->execute();
            $ingredientId = $pdo->lastInsertId();

            $stmt = $pdo->prepare("INSERT INTO recipe_ingredients (recipe_id, ingredient_id) VALUES (:recipe_id, :ingredient_id)");
            $stmt->bindParam(':recipe_id', $recipeId);
            $stmt->bindParam(':ingredient_id', $ingredientId);
            $stmt->execute();
        }

        $pdo->commit();
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    }
}

// Fetch ingredients for a recipe
function getIngredientsForRecipe($pdo, $recipeId) {
    $sql = "SELECT i.ingredient 
            FROM ingredients i 
            INNER JOIN recipe_ingredients ri ON i.id = ri.ingredient_id 
            WHERE ri.recipe_id = :recipe_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':recipe_id', $recipeId);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

// Fetch recipes with a specific ingredient
function getRecipesWithIngredient($pdo, $ingredientName) {
    $sql = "SELECT r.name 
            FROM recipes r
            INNER JOIN recipe_ingredients ri ON r.id = ri.recipe_id
            INNER JOIN ingredients i ON i.id = ri.ingredient_id
            WHERE i.ingredient = :ingredient_name";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':ingredient_name', $ingredientName);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

function initializeCategories($pdo) {
    // Check if $categories is already set in session
    if (!isset($_SESSION['categories'])) {
        $checkTable = $pdo->query("SHOW TABLES LIKE 'categories'");
        if ($checkTable->rowCount() == 0) {
            // Table doesn't exist, create it
            createCategoriesTable($pdo);

            // Fetch categories from MealDB API
            $categories = fetchCategories();

            // Store categories in the database
            if ($categories) {
                storeCategoriesInDB($pdo, $categories);
                echo "Successfully created and stored categories table in the database!<br>";
            }
        } else {
            $stmt = $pdo->query("SELECT ingredient FROM categories");
            $categories = $stmt->fetchAll(PDO::FETCH_COLUMN);
            echo "Categories table already exists!<br>";
        }

        // Store categories in session
        $_SESSION['categories'] = $categories;
    } else {
        // Retrieve categories from session
        $categories = $_SESSION['categories'];
    }

    return $categories;
}
?>
