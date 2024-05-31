if (lightModeToggle) {
        lightModeToggle.addEventListener('click', () => {
            const newLightMode = document.body.classList.toggle('light-mode2');
            localStorage.setItem('lightMode', newLightMode);
        });
    } else {
        console.error('Light mode toggle button not found');
    }

    function toggleLightMode(isLightMode) {
        if (isLightMode) {
            document.body.classList.add('light-mode');
        } else {
            document.body.classList.remove('light-mode');
        }
    }

document.getElementById('ingredSearch').addEventListener('click', function() {
  window.location.href = '../RecipeCode/RecipeIngredients.php';
});

document.getElementById('dishSearch').addEventListener('click', function() {
  window.location.href = '../RecipeCode/RecipeName.php';
});
