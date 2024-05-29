<?php
//Getting recipe by name
function fetchRecipesByName($name) {
    $url = "https://www.themealdb.com/api/json/v1/1/search.php?s={$name}";
    $response = file_get_contents($url);
    if($response !== false) {
        $data = json_decode($response, true);
        if(isset($data['meals']) && !empty($data['meals'])){
            foreach($data['meals'] as $recipe) {
                $ings = []; // Initialize $ings array
                for ($i = 1; $i <= 20; $i++) { 
                    // Get the ingredient
                    $ing = $recipe['strIngredient' . $i];
                    if ($ing && !is_null($ing)) { // Check if the ingredient exists and is not null
                        $ing = ucfirst($ing);
                        $ings[] = $ing;
                    }
                }
                $idMeal = $recipe['idMeal'];
                $nameMeal = $recipe['strMeal'];
                $imgMeal = $recipe['strMealThumb'];
                printRecipe($ings, $idMeal, $nameMeal, $imgMeal);
            }
        } else {
            echo "No meal found for {$name}";
        }
    } else {
        echo "Failed to fetch data from MealDB API.";
    }
}



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
            echo "My bad bro, no recipe with that name on my data. ¯\_(ツ)_/¯";
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
        $userIngredient = ucfirst(strtolower($userIngredient));
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
                //Get the name of the meal
                $name = $recipe[1];
                //Get the url image of the meal
                $imgMeal = $recipe[2];
                //Printing out the data
                if(isArraySubset($enteredIngredients, $recipe[0])); {
                    printRecipe($enteredIngredients, $idMeal, $name, $imgMeal);
                    printMissingIngredients($enteredIngredients, $recipe[0]);
                }
            }
        } else {
            echo "No recipes found for the given ingredient.";
        }
    } else {
        echo "Failed to fetch data from MealDB api.";
    }
}

//Getting the recipe by id
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
                    $ing = ucfirst($meal['strIngredient' . $i]);
                    if ($ing) {
                        $ings[] = $ing;
                    }
                }
            }
            //Get the name of the meal
            $nameMeal = $meal['strMeal'];
            //Get the url of the image of the meal
            $imageMeal = $meal['strMealThumb'];
            return [$ings, $nameMeal, $imageMeal];
        } else {
            echo "No meal found for idMeal {$idMeal}.";
        }
    } else {
        echo "Failed to fetch data from MealDB API.";
    }
    return NULL;
}

//Print the data
function printRecipe($ings, $id, $name, $img) {
    echo "Ingredients for idMeal {$id} {$name}: <br>";
    //Display the image of the meal
    echo "<img src='$img' alt='Recipe Image' style='max-width: 200px;'><br>";
    foreach($ings as $ingre) echo "$ingre <br>";
    echo "<br>";
}

//Check if the user inputted ingredient is one of the existing ingredient of the website
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
