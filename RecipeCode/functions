<?php
function fetchCategories() {
    $url = "https://www.themealdb.com/api/json/v1/1/list.php?i=list";
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

function addIngredient(&$enteredIngredients, $categories) {
    $userIngredient = isset($_POST["search"]) ? $_POST["search"] : '';
    if ($userIngredient === "") {
        echo "Please enter an ingredient.";
        return;
    } else if (in_array(strtolower($userIngredient), array_map('strtolower', $categories))) {
        if (!in_array($userIngredient, $enteredIngredients)) {
            $enteredIngredients[] = $userIngredient;
        }
    } else {
        echo "<p>Search term '$userIngredient' not found! Please select from the list.</p>";
        return;
    }
}

function removeIngredient(&$enteredIngredients) {
    $removedIngredient = $_POST['removedIngredient'];
    $enteredIngredients = array_filter($enteredIngredients, function($ing) use ($removedIngredient) {
        return $ing !== $removedIngredient;
    });
}

function fetchRecipes($enteredIngredients) {
    foreach ($enteredIngredients as $ingredient) {
        fetchRecipesByIngredient($ingredient, $enteredIngredients);
    }
}

function fetchRecipesByIngredient($ing, $enteredIngredients) {
    $url = "https://www.themealdb.com/api/json/v1/1/filter.php?i={$ing}";
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
    $url = "https://www.themealdb.com/api/json/v1/1/lookup.php?i={$idMeal}";
    $response = file_get_contents($url);
    if ($response) {
        $data = json_decode($response, true);
        if (isset($data['meals']) && !empty($data['meals'])) {
            $ings = array();
            foreach ($data['meals'] as $meal) {
                for ($i = 1; $i <= 20; $i++) { 
                    $ing = $meal['strIngredient' . $i];
                    if ($ing) {
                        $ings[] = $ing;
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

function printIngredients($ings, $recipeIng, $id) {
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
        $ing = strtolower(trim($ing));
        if (!in_array($ing, $userIngredients)) {
            $missingIngredients[] = $ing;
        }
    }
    return $missingIngredients;
}

function printMissingIngredients($userIngredients, $recipeIngredients) {
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

?>
