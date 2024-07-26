<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriAlert</title>
    <link rel="stylesheet" href="./css/css.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<?php 
    session_start(); // Start the session
    include 'nav footer/user_nav.php'; // NAVIGATION
    include_once 'config/db_connection.php'; // Database connection

    $mysqli = mysqli_connect_mysql(); // Initialize the database connection
?>

<div class="dashboard-box">
    <h1>Search Results</h1>
    <?php
        // Get the search query
        $query = isset($_GET['query']) ? $_GET['query'] : '';
		
		// Retrieve selected values from GET request
		$selectedIngredients = isset($_GET['ingredients']) ? $_GET['ingredients'] : [];
		$selectedAllergies = isset($_GET['allergies']) ? $_GET['allergies'] : [];
		$selectedConditions = isset($_GET['conditions']) ? $_GET['conditions'] : [];
		$selectedConsiderations = isset($_GET['considerations']) ? $_GET['considerations'] : [];
		
		$like_query = "%$query%";


// Retrieve selected values from GET request
$selectedIngredients = isset($_GET['ingredients']) ? $_GET['ingredients'] : [];
$selectedAllergies = isset($_GET['allergies']) ? $_GET['allergies'] : [];
$selectedConditions = isset($_GET['conditions']) ? $_GET['conditions'] : [];
$selectedConsiderations = isset($_GET['considerations']) ? $_GET['considerations'] : [];

// Initialize the filter query
$filterquery = "SELECT DISTINCT r.recipe_id, r.recipe_name
                FROM recipes r
                LEFT JOIN ingredients i ON r.recipe_id = i.ingredient_recipe_id
                LEFT JOIN conditions c ON r.recipe_id = c.condition_recipe_id
                LEFT JOIN allergies a ON r.recipe_id = a.allergy_recipe_id
                LEFT JOIN considerations cons ON r.recipe_id = cons.consideration_recipe_id
                WHERE 1=1";

// Add conditions for ingredients
if (!empty($selectedIngredients)) {
    $escapedIngredients = array_map(function($ingredient) use ($mysqli) {
        return mysqli_real_escape_string($mysqli, $ingredient);
    }, $selectedIngredients);
    $ingredientsList = implode("','", $escapedIngredients);
    $filterquery .= " AND i.ingredient_name IN ('$ingredientsList')";
}

// Add conditions for allergies
if (!empty($selectedAllergies)) {
    $escapedAllergies = array_map(function($allergy) use ($mysqli) {
        return mysqli_real_escape_string($mysqli, $allergy);
    }, $selectedAllergies);
    $allergiesList = implode("','", $escapedAllergies);
    $filterquery .= " AND a.allergy_name IN ('$allergiesList')";
}

// Add conditions for health conditions
if (!empty($selectedConditions)) {
    $escapedConditions = array_map(function($condition) use ($mysqli) {
        return mysqli_real_escape_string($mysqli, $condition);
    }, $selectedConditions);
    $conditionsList = implode("','", $escapedConditions);
    $filterquery .= " AND c.condition_name IN ('$conditionsList')";
}

// Add conditions for other considerations
if (!empty($selectedConsiderations)) {
    $escapedConsiderations = array_map(function($consideration) use ($mysqli) {
        return mysqli_real_escape_string($mysqli, $consideration);
    }, $selectedConsiderations);
    $considerationsList = implode("','", $escapedConsiderations);
    $filterquery .= " AND cons.consideration_name IN ('$considerationsList')";
}
/*echo "<pre>" . htmlspecialchars($filterquery) . "</pre>";*/

// Execute the filter query
$filterresult = mysqli_query($mysqli, $filterquery);

// Fetch and display results
$filterRecipeIDs = [];
if ($filterresult && mysqli_num_rows($filterresult) > 0) {
    while ($row = mysqli_fetch_assoc($filterresult)) {
        $filterRecipeIDs[] = $row['recipe_id'];
    }
} else {
    echo "No recipes found matching your criteria.";
}




$searchRecipeIDs = [];
$sql = "SELECT recipe_id FROM recipes WHERE recipe_name LIKE ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $like_query);
$stmt->execute();
$result = $stmt->get_result();

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $searchRecipeIDs[] = $row['recipe_id'];
    }
}

$combinedRecipeIDs = array_intersect($filterRecipeIDs, $searchRecipeIDs);


        // Fetch recipes based on search query
        if (!empty($combinedRecipeIDs)) {
    $combinedIDsList = implode(",", $combinedRecipeIDs);
    $sql = "SELECT * FROM recipes WHERE recipe_id IN ($combinedIDsList)";
    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
		}
        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                while ($recipe = mysqli_fetch_assoc($result)) {
                    // Retrieve the user's name from the 'users' table based on user_id
                    $user_id = $recipe['recipe_posted_by_id'];
                    $userQuery = "SELECT user_first_name, user_last_name FROM users WHERE user_id = ?";
                    $userStmt = $mysqli->prepare($userQuery);
                    $userStmt->bind_param("i", $user_id);
                    $userStmt->execute();
                    $userResult = $userStmt->get_result();

                    if ($userResult->num_rows == 1) {
                        $userRow = $userResult->fetch_assoc();
                        $postedByName = "Chef " . $userRow["user_first_name"] . " " . $userRow["user_last_name"];
                    } else {
                        $postedByName = "Unknown Chef";
                    }

                    // Fetch the ingredients for the given recipe
                    $recipe_id = $recipe["recipe_id"];
                    $getIngredients = "SELECT ingredient_name FROM ingredients WHERE ingredient_recipe_id=?";
                    $ingredientStmt = $mysqli->prepare($getIngredients);
                    $ingredientStmt->bind_param("i", $recipe_id);
                    $ingredientStmt->execute();
                    $result2 = $ingredientStmt->get_result();
    ?>
    <div class="dashboard-box-recipe">
        <div class="dashboard-recipe-image">
            <img src='./images/<?=$recipe['recipe_image']?>' alt='<?=$recipe["recipe_name"]?>' style="max-width: 300px; max-height: 300px;">
        </div>
        <div class="dashboard-recipe-info">
            <div class="dashboard-recipe-info-info">
                <b><?php echo $recipe["recipe_name"]; ?></b>
                <i><?php echo $postedByName; ?></i>
                <i class="bi bi-clock"><?php echo ' ' . $recipe["recipe_time"] . ' minutes'; ?></i>
                <br/>
                <p>Ingredients</p>
                <ol>
                    <?php
                        if ($result2 && mysqli_num_rows($result2) > 0) {
                            while ($ingredient = mysqli_fetch_assoc($result2)) {
                                echo '<li>' . $ingredient["ingredient_name"] . '</li>';
                            }
                        } else {
                            echo '<li>No ingredients found</li>';
                        }
                    ?>
                </ol>         
            </div>
            <div class="dashboard-recipe-desc">
                <b>Nutritional Details / Recipe Description</b>
                <p><?php echo $recipe["recipe_description"]; ?></p>

                <div class="view">
                    <a href="recipe_detail.php?id=<?php echo $recipe['recipe_id']; ?>">View More</a>
                </div>
            </div>
        </div> 
    </div>
    <?php
                }
            } else {
                echo '<p style="background-color: white;">No recipes found</p>';
            }
        } else {
            echo 'Error: ' . mysqli_error($mysqli);
        }
    ?>
</div>
<?php include './nav footer/user_footer.php'; ?>    <!-- FOOTER -->
</body>
</html>
