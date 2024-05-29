<?php
include 'functions.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Recipe Finder By Name</title>
    <script src="script.js"></script>
</head>
<body>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="search">Enter recipe name:</label>
        <input type="text" id="search" name="search">
        <button type="submit" name="action" value="searchRecipes">Search</button>
    </form>
</body>
</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the recipe name from the form
    $name = $_POST['search'];

    // Call the function to fetch recipes by name
    fetchRecipesByName($name);
}
?>