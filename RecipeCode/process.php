<?php
if ($_POST['action'] == 'addIngredient') {
    addIngredient($enteredIngredients, $categories);
} elseif ($_POST['action'] == 'searchRecipes') {
    fetchRecipes($enteredIngredients);
} elseif ($_POST['action'] == 'removeIngredient') {
    removeIngredient($enteredIngredients);
}
?>

<input type="hidden" name="enteredIngredients" value="<?php echo htmlspecialchars(json_encode($enteredIngredients)); ?>">