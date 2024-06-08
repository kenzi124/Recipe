//When clicking the displayed ingredient button, delete it
function removeButton(buttonId, ingredient) {
    //Remove the button element from the DOM
    var button = document.getElementById(buttonId);
    button.parentNode.removeChild(button);

    //Set the value of the hidden input field to the ingredient to be removed
    document.getElementById('removedIngredient').value = ingredient;

    //Submit the form to trigger the removal in PHP
    document.getElementById('removeIngredientForm').submit();
}

//Function to create and display meal details on popup
function showMealDetailsPopup(meal) {

}