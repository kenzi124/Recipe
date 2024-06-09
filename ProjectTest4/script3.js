function toggleLightMode(isLightMode) {
    if (isLightMode) {
        document.body.classList.add('light-mode3');
    } else {
        document.body.classList.remove('light-mode3');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const lightModeToggle = document.getElementById('lightModeToggle');
    if (lightModeToggle) {
        lightModeToggle.addEventListener('click', () => {
            const isLightMode = document.body.classList.toggle('light-mode3');
            localStorage.setItem('lightMode', isLightMode);
        });

        const isLightMode = JSON.parse(localStorage.getItem('lightMode'));
        toggleLightMode(isLightMode);
    } else {
        console.error('Light mode toggle button not found');
    }

    const modal = document.getElementById('popupModal');
    const span = document.getElementsByClassName('close')[0];

    span.onclick = function() {
        modal.style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
});
function showPopup(recipe) {
    document.getElementById('popupTitle').textContent = recipe.name;
    document.getElementById('popupImage').src = recipe.image;
    const ingredientsList = document.getElementById('popupIngredients');
    ingredientsList.innerHTML = '';
    recipe.ingredients.forEach(ingredient => {
        const li = document.createElement('li');
        li.textContent = ingredient;
        ingredientsList.appendChild(li);
    });
    document.getElementById('popupModal').style.display = 'block';
}