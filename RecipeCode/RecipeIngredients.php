<?php
session_start(); // Start session

//include 'config.php';
include 'functions.php';
//include 'database.php';

// Initialize categories
$categories = fetchCategories();

// Initialize entered ingredients
$enteredIngredients = handleFormSubmission($categories); 
?>
 
<!DOCTYPE html>
<html>
<head>
    <title>Recipe Finder By Ingredients</title>
    <script src="script4.js"></script>
    <link rel="stylesheet" href="style4.css">
    <link rel ="stylesheet" href="light-mode4.css">
</head>
<body>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="search">Enter ingredients:</label>
        <input type="text" id="search" name="search" list="searchList">
        <button type="submit" name="action" value="addIngredient">Add</button>
        <button type="submit" name="action" value="searchRecipes">Search</button>
        <datalist id="searchList">
            <?php 
            foreach($categories as $outIng) {
                echo "<option value='$outIng'>";
            }
            ?>
        </datalist>

        <input type="hidden" name="enteredIngredients" value="<?php echo htmlspecialchars(json_encode($enteredIngredients)); ?>">
    </form>

    <!-- Displaying ingredient as button -->
    <div id="ingredientButtons">
        <?php
        if (!empty($enteredIngredients)) {
            foreach ($enteredIngredients as $index => $name) {
                echo '<button type="button" id="button' . $index . '" onclick="removeButton(\'button' . $index . '\', \'' . $name . '\')">' . $name . '</button>';
            }
        }
        ?>
    </div>

    <form method="post" id="removeIngredientForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="action" value="removeIngredient">
        <input type="hidden" id="removedIngredient" name="removedIngredient" value="">
        <input type="hidden" name="enteredIngredients" value="<?php echo htmlspecialchars(json_encode($enteredIngredients)); ?>">
    </form>

    <?php
    // If the search button is pressed, display recipes
    if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == 'searchRecipes') {
        fetchRecipes($enteredIngredients);
    }
    ?>
    <button type="button" id="lightModeToggle" class="btmright">Light Mode</button>
</body>
</html>
