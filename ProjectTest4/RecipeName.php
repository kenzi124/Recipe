<!DOCTYPE html>
<html>
<head>
    <title>Recipe Finder By Name</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js"></script>
</head>
<body>
    <div class="container">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="search">Enter recipe name:</label>
            <input type="text" id="search" name="search">
            <button type="submit" name="action" value="searchRecipes">Search</button>
        </form>
    </div>

    <!-- The Modal -->
    <div id="recipeModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="modal-body"></div>
        </div>
    </div>

    <?php
    include 'functions.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['search'];
        fetchRecipesByName($name);
    }
    ?>
</body>
</html>
