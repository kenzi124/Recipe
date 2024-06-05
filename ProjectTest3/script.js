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

    // Registration Form Validation
    const registerButton = document.getElementById('registerButton');
    if (registerButton) {
        console.log('Register button found'); 

        registerButton.addEventListener('click', function() {
            console.log('Register button clicked'); 

            var password = document.getElementById('pwd').value;
            var confirmPassword = document.getElementById('pwd2').value;
            var errorMessage = document.getElementById('error-message');

            if (password === confirmPassword) {
                console.log('Passwords match'); 
                errorMessage.style.display = 'none'; 
                document.getElementById('registerForm').submit();
            } else {
                console.log('Passwords do not match'); 
                errorMessage.style.display = 'block'; 
            }
        });

        // Additional event listener to clear the error message if passwords match
        document.getElementById('pwd2').addEventListener('input', function() {
            var password = document.getElementById('pwd').value;
            var confirmPassword = document.getElementById('pwd2').value;
            var errorMessage = document.getElementById('error-message');

            if (password === confirmPassword) {
                errorMessage.style.display = 'none';
            }
        });
    } else {
        console.error('Register button not found');
    }
});