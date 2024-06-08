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
//function showMealDetailsPopup(meal) {
//}

function toggleLightMode(isLightMode) {
    if (isLightMode) {
        document.body.classList.add('light-mode4');
    } else {
        document.body.classList.remove('light-mode4');
    }
}

// Event listener for light mode toggle button
document.addEventListener('DOMContentLoaded', () => {
    const lightModeToggle = document.getElementById('lightModeToggle');
    if (lightModeToggle) {
        lightModeToggle.addEventListener('click', () => {
            const isLightMode = document.body.classList.toggle('light-mode4');
            localStorage.setItem('lightMode', isLightMode);
        });

        // Check and apply the light mode setting from localStorage on page load
        const isLightMode = JSON.parse(localStorage.getItem('lightMode'));
        toggleLightMode(isLightMode);
    } else {
        console.error('Light mode toggle button not found');
    }
});
