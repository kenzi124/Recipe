function removeButton(buttonId, ingredient) {
    var button = document.getElementById(buttonId);
    button.parentNode.removeChild(button);
    document.getElementById('removedIngredient').value = ingredient;
    document.getElementById('removeIngredientForm').submit();
}
