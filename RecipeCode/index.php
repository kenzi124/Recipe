<?php
include 'functions.php';
$categories = fetchCategories();
$enteredIngredients = isset($_POST['enteredIngredients']) ? json_decode($_POST['enteredIngredients'], true) : [];
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    include 'process.php';
}
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
    <datalist id="searchList">
        <?php 
        foreach($categories as $outIng) {
            echo "<option value='$outIng'>";
        }
        ?>
    </datalist>
    <div id="ingredientButtons">
        <?php
        foreach($enteredIngredients as $index => $name) {
            echo '<button type="button" id="button' . $index . '" onclick="removeButton(\'button' . $index . '\', \'' . $name . '\')">' . $name . '</button>';
        }
        ?>
    </div>
    <input type="hidden" name="enteredIngredients" value="<?php echo htmlspecialchars(json_encode($enteredIngredients)); ?>">
</form>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input type="hidden" name="enteredIngredients" value="<?php echo htmlspecialchars(json_encode($enteredIngredients)); ?>">
    <button type="submit" name="action" value="searchRecipes">Search</button>
</form>

<form method="post" id="removeIngredientForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input type="hidden" name="action" value="removeIngredient">
    <input type="hidden" id="removedIngredient" name="removedIngredient" value="">
    <input type="hidden" name="enteredIngredients" value="<?php echo htmlspecialchars(json_encode($enteredIngredients)); ?>">
</form>

</body>
</html>
