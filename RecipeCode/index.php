<?php
include 'functions.php';
$categories = fetchCategories();
$enteredIngredients = isset($_POST['enteredIngredients']) ? json_decode($_POST['enteredIngredients'], true) : [];
//If the add button is been pressed
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == 'addIngredient') addIngredient($enteredIngredients, $categories);
//If the user removed ingredients
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == 'removeIngredient') removeIngredient($enteredIngredients);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Recipe Finder</title>
    <script src="script.js"></script>
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
        foreach($enteredIngredients as $index => $name) {
            echo '<button type="button" id="button' . $index . '" onclick="removeButton(\'button' . $index . '\', \'' . $name . '\')">' . $name . '</button>';
        }
        ?>
    </div>

    <?php
    //If the search button is been pressed
    if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == 'searchRecipes') fetchRecipes($enteredIngredients);
    ?>
    
    <form method="post" id="removeIngredientForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="action" value="removeIngredient">
        <input type="hidden" id="removedIngredient" name="removedIngredient" value="">
        <input type="hidden" name="enteredIngredients" value="<?php echo htmlspecialchars(json_encode($enteredIngredients)); ?>">
    </form>
    <form metthod="post" id="ingredientMode" action="
    <?php
    ?>
</body>
</html>
