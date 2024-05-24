<?php 
$api_key = '1';
$categories = fetchCategories();
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="search">Enter ingredients (separated by commas):</label>
    <input type="text" id="search" name="search" list="searchList"><br><br>
    <datalist id="searchList"> 
        <?php 
        foreach($categories as $outIng) {
            echo "<option value='$outIng'>";
        }
        ?>
    </datalist>
    <button type="submit">Search</button>
</form>

<?php 
function fetchCategories() {
    global $api_key;
    $url = "https://www.themealdb.com/api/json/v1/{$api_key}/list.php?i=list";
    $response = file_get_contents($url);
    if ($response) {
        $data = json_decode($response, true);
        if (isset($data['meals']) && !empty($data['meals'])) {
            $categories = array();
            foreach ($data['meals'] as $meal) {
                $categories[] = $meal['strIngredient'];
            }
            return $categories;
        } else {
            return array();
        }
    } else {
        echo "Failed to fetch data from MealDB API.";
        return false;
    }
}

function printIngredients($ings, $recipeIng, $id){
    if (isArraySubset($ings, $recipeIng)) {
        $recipe = array();
        echo "Ingredients for idMeal {$id}: <br>";
        foreach($recipeIng as $ingre){
            echo "$ingre <br>";
        }
        echo "<br>";
    }
    return $recipe;
}

function isArraySubset($array1, $array2) {
    $lowerArray1 = array_map('strtolower', $array1);
    $lowerArray2 = array_map('strtolower', $array2);
    $trimmedArray1 = array_map('trim', $lowerArray1);
    $trimmedArray2 = array_map('trim', $lowerArray2);
    foreach ($trimmedArray1 as $value) {
        if (!in_array($value, $trimmedArray2)) return false;
    }
    return true;
} 

function findMissingIngredients($recipeIngredients, $userIngredients) {
    $missingIngredients = array();
    foreach ($recipeIngredients as $ing) {
        $ing= strtolower(trim($ing));
        if (!in_array($ing, $userIngredients)) {
            array_push($missingIngredients, $ing);
        }
    }
    return $missingIngredients;
}

function printMissingIngredients($userIngredients, $recipeIngredients){
    if ($recipeIngredients !== false) {
        $missingIngredients = findMissingIngredients($recipeIngredients, $userIngredients);
        if (!empty($missingIngredients)) {
            echo "Missing ingredients for the recipe:<br>";
            foreach ($missingIngredients as $ingredient) {
                echo "- $ingredient<br>";
            }
        } else {
            echo "No missing ingredients. You have all the ingredients needed for the recipe!";
        }
    } else {
        echo "Failed to fetch recipe ingredients.";
    }
}

function fetchRecipesByIngredient($ing, $ings) {
    global $api_key;
    $url = "https://www.themealdb.com/api/json/v1/{$api_key}/filter.php?i={$ing}";
    $response = file_get_contents($url);
    if ($response) {
        $data = json_decode($response, true);
        if (isset($data['meals']) && !empty($data['meals'])) {
            $recipes = array();
            foreach ($data['meals'] as $recipe) {
                $idMeal = $recipe['idMeal'];
                $recipeIngredients = fetchIngredientsByIdMeal($idMeal);
                array_push($recipes, printIngredients($ings, $recipeIngredients, $idMeal));
            }
        } else {
            echo "No recipes found for the given ingredient.";
        }
    } else {
        echo "Failed to fetch data from MealDB API.";
    }
}

function fetchIngredientsByIdMeal($idMeal) {
    global $api_key;
    $url = "https://www.themealdb.com/api/json/v1/{$api_key}/lookup.php?i={$idMeal}";
    $response = file_get_contents($url);
    if ($response) {
        $data = json_decode($response, true);
        if (isset($data['meals']) && !empty($data['meals'])) {
            $ings = array();
            foreach ($data['meals'] as $meal) {
                for ($i = 1; $i <= 20; $i++) { 
                    $ing = $meal['strIngredient' . $i];
                    if ($ing) {
                        array_push($ings, $ing);
                    }
                }
            }
            return $ings;
        } else {
            echo "No meal found for idMeal {$idMeal}.";
        }
    } else {
        echo "Failed to fetch data from MealDB API.";
    }
    return NULL;


}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputIngredients = isset($_POST["search"]) ? $_POST["search"]: '';
    $ingredients = explode(',', $inputIngredients);
    $ingredients = array_map('trim', $ingredients);
    foreach($ingredients as $ingredient) {
        if(in_array(strtolower($ingredient), array_map('strtolower', $categories))) {
            echo "<p>Search term '$ingredient' found!</p>";
        } else {
            echo "<p>Search term '$ingredient' not found! Please select from the list.</p>";
        }
        fetchRecipesByIngredient($ingredient, $ingredients);
    }
}

?>