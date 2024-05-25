<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    if ($_POST['action'] == 'addIngredient') {
        addIngredient($enteredIngredients, $categories);
    } elseif ($_POST['action'] == 'searchRecipes') {
        fetchRecipes($enteredIngredients);
    } elseif ($_POST['action'] == 'removeIngredient') {
        removeIngredient($enteredIngredients);
    }
}
?>
