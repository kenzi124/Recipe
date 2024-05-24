<?php 
$api_key = '1';
$categories = fetchCategories();
$enteredIngredients=array();
$userIngredients=[];
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="search">Enter ingredients (separated by commas):</label>
    <input type="text" id="search" name="search" list="searchList">
    <button type="submit">Search</button>
    <datalist id="searchList"> 
        <?php 
        foreach($categories as $outIng) {
            echo "<option value='$outIng'>";
        }
        ?>
    </datalist>
    <div id="ingredientButtons"></div>
</form>

<script>
    function removeButton(buttonId) {
        var button = document.getElementById(buttonId);
        button.parentNode.removeChild(button);
    }
</script>

<?php 

function addIngredient() {
    global $enteredIngredients, $categories;
    $userIngredient = isset($_POST["search"]) ? $_POST["search"]: '';
    if ($userIngredient === "") {
        echo "Please enter an ingredient.";
        return;
    } else if (in_array(strtolower($userIngredient), array_map('strtolower', $categories))) {
        echo "<p>Search term '$userIngredient' found!</p>";
        array_push($enteredIngredients, $userIngredient);
        displayIngredients();
        fetchRecipesByIngredient($userIngredient);
    } else {
        echo "<p>Search term '$userIngredient' not found! Please select from the list.</p>";
        return;
    }
}

function displayIngredients() {
    global $enteredIngredients;
    foreach($enteredIngredients as $index => $name) {
        echo '<button id="button' . $index . '" onclick="removeButton(\'button' . $index . '\')">' . $name . '</button>';
    }
    echo "<br>";
}

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
        echo "Ingredients for idMeal {$id}: <br>";
        foreach($ings as $ingre){
            echo "$ingre <br>";
        }
        printMissingIngredients($ings, $recipeIng);
        echo "<br>";
    }
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

function fetchRecipesByIngredient($ing) {
    global $api_key, $enteredIngredients;
    $url = "https://www.themealdb.com/api/json/v1/{$api_key}/filter.php?i={$ing}";
    $response = file_get_contents($url);
    if ($response) {
        $data = json_decode($response, true);
        if (isset($data['meals']) && !empty($data['meals'])) {
            foreach ($data['meals'] as $recipe) {
                $idMeal = $recipe['idMeal'];
                $recipeIngredients = fetchIngredientsByIdMeal($idMeal);
                printIngredients($enteredIngredients, $recipeIngredients, $idMeal);
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
    addIngredient();
}

?>