<?php
//Getting available keywords of food ingredient
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

//Add Ingredient
function addIngredient(&$enteredIngredients, $categories) {
    $userIngredient = isset($_POST["search"]) ? $_POST["search"] : '';
    //If there is nothing added
    if ($userIngredient === "") {
        echo "Please enter an ingredient.";
        return;
    //Check if the $userIngredient is one of the keywords inside $categories
    } else if (in_array(strtolower($userIngredient), array_map('strtolower', $categories))) {
        if (!in_array($userIngredient, $enteredIngredients)) {
            $enteredIngredients[] = $userIngredient;
        }
    //If the input ingredient is not found
    } else {
        echo "<p>Search term '$userIngredient' not found! Please select from the list.</p>";
        return;
    }
}

//Removing the ingredient that is been deleted from the $enteredIngredient array
function removeIngredient(&$enteredIngredients) {
    $removedIngredient = $_POST['removedIngredient'];
    $enteredIngredients = array_filter($enteredIngredients, function($ing) use ($removedIngredient) {
        return $ing !== $removedIngredient;
    });
}

//Getting all the recipe from the array $enteredIngredients
function fetchRecipes($enteredIngredients) {
    foreach ($enteredIngredients as $ingredient) {
        fetchRecipesByIngredient($ingredient, $enteredIngredients);
    }
}

//Getting all the recipe and printing out the name, id, and ingredients
function fetchRecipesByIngredient($ing, $enteredIngredients) {
    $url = "https://www.themealdb.com/api/json/v1/1/filter.php?i={$ing}";
    $response = file_get_contents($url);
    //Check if they fetch the contents from the website
    if ($response) {
        //Convert the json string into a PHP data structure
        $data = json_decode($response, true);
        //Check if the website is there such data called 'meals'
        if (isset($data['meals']) && !empty($data['meals'])) {
            foreach ($data['meals'] as $recipe) {
                $idMeal = $recipe['idMeal'];
                //Getting the recipe
                $recipe = fetchIngredientsByIdMeal($idMeal);
                $name = $recipe[1];
                //Printing out the data
                printIngredients($enteredIngredients, $recipe[0], $idMeal, $name);
            }
        } else {
            echo "No recipes found for the given ingredient.";
        }
    } else {
        echo "Failed to fetch data from MealDB api.";
    }
}

//Getting the ingredients by id
function fetchIngredientsByIdMeal($idMeal) {
    $url = "https://www.themealdb.com/api/json/v1/1/lookup.php?i={$idMeal}";
    $response = file_get_contents($url);
    //Check if they fetch the contents from the website
    if ($response) {
        //Convert the json string into a PHP data structure
        $data = json_decode($response, true);
        //Check if the website is there such data called 'meals'
        if (isset($data['meals']) && !empty($data['meals'])) {
            //Read every 'meals' data
            foreach ($data['meals'] as $meal) {
                for ($i = 1; $i <= 20; $i++) { 
                    //Get the ingredient
                    $ing = $meal['strIngredient' . $i];
                    if ($ing) {
                        $ings[] = $ing;
                    }
                }
            }
            //Get the name of the meal
            $name = $meal['strMeal'];
            return [$ings, $name];
        } else {
            echo "No meal found for idMeal {$idMeal}.";
        }
    } else {
        echo "Failed to fetch data from MealDB API.";
    }
    return NULL;
}

//Print the ingredients
function printIngredients($ings, $recipeIng, $id, $name) {
    if (isArraySubset($ings, $recipeIng)) {
        echo "Ingredients for idMeal {$id} {$name}: <br>";
        foreach($ings as $ingre){
            echo "$ingre <br>";
        }
        printMissingIngredients($ings, $recipeIng);
        echo "<br>";
    }
}

//Check if array1 has all the string inside array2
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

//Find missing ingredients
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

//Print out missing ingredients
function printMissingIngredients($userIngredients, $recipeIngredients) {
    //Check if the data can't be fetched
    if ($recipeIngredients !== false) {
        $missingIngredients = findMissingIngredients($recipeIngredients, $userIngredients);
        //Check if there is any missing ingredients
        if (!empty($missingIngredients)) {
            echo "Missing ingredients for the recipe:<br>";
            //Commence printing out the missing ingredients
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
