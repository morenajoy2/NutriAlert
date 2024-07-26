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

    $connect = mysqli_connect_mysql(); // Initialize the database connection
?>

<div class="dashboard-box">
    <h1>Trending Recipes</h1>
    <?php
        // Fetch the recipe details
        $sql = "SELECT * FROM recipes";
        $result = mysqli_query($connect, $sql);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                while ($recipe = mysqli_fetch_assoc($result)) {
                    // Retrieve the user's name from the 'users' table based on user_id
                    $user_id = $recipe['recipe_posted_by_id'];
                    $userQuery = "SELECT user_first_name, user_last_name FROM users WHERE user_id = ?";
                    $userStmt = $connect->prepare($userQuery);
                    $userStmt->bind_param('i', $user_id);
                    $userStmt->execute();
                    $userResult = $userStmt->get_result();

                    if ($userResult->num_rows == 1) {
                        $userRow = $userResult->fetch_assoc();
                        $postedByName = "Chef " . htmlspecialchars($userRow["user_first_name"]) . " " . htmlspecialchars($userRow["user_last_name"]);
                    } else {
                        $postedByName = "Unknown Chef";
                    }

                    // Fetch the ingredients for the given recipe
                    $recipe_id = $recipe["recipe_id"];
                    $getIngredients = "SELECT ingredient_name FROM ingredients WHERE ingredient_recipe_id = ?";
                    $ingredientStmt = $connect->prepare($getIngredients);
                    $ingredientStmt->bind_param('i', $recipe_id);
                    $ingredientStmt->execute();
                    $result2 = $ingredientStmt->get_result();
    ?>
    <div class="dashboard-box-recipe"> 
        <div class="dashboard-recipe-image">
            <img src='./images/<?php echo htmlspecialchars($recipe['recipe_image']); ?>' alt='<?php echo htmlspecialchars($recipe["recipe_name"]); ?>' style="max-width: 300px; max-height: 300px;">
        </div>
        <div class="dashboard-recipe-info">
            <div class="dashboard-recipe-info-info">
                <b><?php echo htmlspecialchars($recipe["recipe_name"]); ?></b>
                <i><?php echo $postedByName; ?></i>
                <i class="bi bi-clock"><?php echo ' ' . htmlspecialchars($recipe["recipe_time"]) . ' minutes'; ?></i>
                <br/>
                <p>Ingredients</p>
                <ol>
                    <?php
                        if ($result2 && mysqli_num_rows($result2) > 0) {
                            while ($ingredient = mysqli_fetch_assoc($result2)) {
                                echo '<li>' . htmlspecialchars($ingredient["ingredient_name"]) . '</li>';
                            }
                        } else {
                            echo '<li style="background-color: white;">No ingredients found</li>';
                        }
                    ?>
                </ol>         
            </div>
            <div class="dashboard-recipe-desc">
                <b>Nutritional Details / Recipe Description</b>
                <p><?php echo htmlspecialchars($recipe["recipe_description"]); ?></p>

                <div class="view">
                    <a href="recipe_detail.php?id=<?php echo htmlspecialchars($recipe['recipe_id']); ?>">View More</a>
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
            echo 'Error: ' . mysqli_error($connect);
        }
        ?>
</div>
<?php include './nav footer/user_footer.php'; ?>    <!-- FOOTER -->
</body>
</html>
