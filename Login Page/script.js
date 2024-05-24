const lightModeToggle = document.getElementById('lightModeToggle');

const isLightMode = localStorage.getItem('lightMode') === 'true';

toggleLightMode(isLightMode);

lightModeToggle.addEventListener('click', () => {
    const newLightMode = document.body.classList.toggle('light-mode');
    localStorage.setItem('lightMode', newLightMode);
});

function toggleLightMode(isLightMode) {
    if (isLightMode) {
        document.body.classList.add('light-mode');
    } else {
        document.body.classList.remove('light-mode');
    }
}
