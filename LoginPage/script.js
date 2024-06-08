document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM fully loaded and parsed'); 

    // Light Mode Toggle Functionality
    const lightModeToggle = document.getElementById('lightModeToggle');
    const isLightMode = localStorage.getItem('lightMode') === 'true';
    toggleLightMode(isLightMode);

    if (lightModeToggle) {
        lightModeToggle.addEventListener('click', () => {
            const newLightMode = document.body.classList.toggle('light-mode');
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
});

function validateForm() {
    var pwd = document.getElementById("pwd").value;
    var pwd2 = document.getElementById("pwd2").value;
    var errorMessage = document.getElementById("error-message");

    if (pwd !== pwd2) {
        errorMessage.style.display = "block";
        return false;
    }
    errorMessage.style.display = "none";
    return true;
}