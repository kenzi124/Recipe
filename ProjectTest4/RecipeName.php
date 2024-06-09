<!DOCTYPE html>
<html>
<head>
    <title>Recipe Finder By Name</title>
    <script src="script3.js"></script>
    <link rel="stylesheet" href="style3.css">
    <link rel="stylesheet" href="light-mode3.css">
</head>
<body>
<main>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div>
            <label for="search">Enter recipe name:</label>
        </div>
        <input type="text" id="search" name="search">
        <div>
            <br>
            <button type="submit" name="action" value="searchRecipes">Search</button>
            <button type="button" id="lightModeToggle" class="btmright">Light Mode</button>
        </div>
    </form>
</main>
<div id="recipeContainer"></div>

<!-- Popup Modal -->
<div id="popupModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2 id="popupTitle"></h2>
        <img id="popupImage" src="" alt="Recipe Image" style="max-width: 200px;">
        <ul id="popupIngredients"></ul>
    </div>
</div>
</body>
</html>

<?php
include 'functions.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['search'];
    fetchRecipesByName($name);
}
?>
