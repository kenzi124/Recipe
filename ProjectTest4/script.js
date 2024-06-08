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

document.addEventListener('DOMContentLoaded', (event) => {
    var modal = document.getElementById('recipeModal');
    var span = document.getElementsByClassName('close')[0];

    span.onclick = function() {
        modal.style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
});

function displayRecipes(recipes) {
    var modal = document.getElementById('recipeModal');
    var modalBody = document.getElementById('modal-body');
    modalBody.innerHTML = "";

    recipes.forEach(function(recipe) {
        var ingredientsList = "<p><strong>Ingredients:</strong></p>";
        recipe.ingredients.forEach(function(ingredient) {
            ingredientsList += "<p>- " + ingredient + "</p>";
        });

        var recipeDetails = `
            <div class="recipe">
                <img src="${recipe.image}" alt="Recipe Image">
                <div class="recipe-details">
                    <strong>${recipe.name}</strong>
                    ${ingredientsList}
                </div>
            </div>
        `;
        modalBody.innerHTML += recipeDetails;
    });

    modal.style.display = 'block';
}
