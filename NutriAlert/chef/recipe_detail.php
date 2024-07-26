<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriAlert</title>
    <link rel="stylesheet" href="../css/css.css">
    <style>
        .recipe-box-box {
            display: flex;
            flex-wrap: wrap;
        }
        .recipe-box-box-box {
            flex: 1;
            max-width: calc(100% - 320px); /* Adjusting the width based on the image size + some space */
            margin-right: 20px; /* Adding space between text and image */
        }
        .recipe-box-image {
            max-width: 300px;
        }
        .recipe-box-image img {
            max-width: 100%;
            max-height: 300px;
        }
        @media screen and (max-width: 768px) {
            .recipe-box-box {
                flex-direction: column;
            }
            .recipe-box-box-box {
                max-width: 100%;
                margin-right: 0;
            }
            .recipe-box-image {
                margin-top: 20px;
            }
        }
    </style>
</head>
<body>
<?php 
session_start();
include "../nav footer/chef_nav.php";
include_once "../config/db_connection.php"; 
$connect = mysqli_connect_mysql(); // Initialize the database connection

if (!$connect) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>

<div class="recipe-box">
    <?php
        // Get id (see the search "php?id=")
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']); // Ensure ID is an integer

            // Prepare the SELECT statement to fetch the recipe data
            $stmt = $connect->prepare("SELECT * FROM recipes WHERE recipe_id = ?");
            if ($stmt) {
                $stmt->bind_param('i', $id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result) {
                    if ($result->num_rows > 0) {
                        $recipe = $result->fetch_assoc();

                        // Retrieve the user's name from the 'users' table based on user_id
                        $user_id = $recipe['recipe_posted_by_id'];
                        $userQuery = $connect->prepare("SELECT user_first_name, user_last_name FROM users WHERE user_id = ?");
                        $userQuery->bind_param('i', $user_id);
                        $userQuery->execute();
                        $userResult = $userQuery->get_result();

                        if ($userResult->num_rows == 1) {
                            $userRow = $userResult->fetch_assoc();
                            $postedByName = "Chef " . htmlspecialchars($userRow["user_first_name"]) . " " . htmlspecialchars($userRow["user_last_name"]);
                        } else {
                            $postedByName = "Unknown Chef";
                        }

                        // Fetch the ingredients for the given recipe
                        $ingredientQuery = $connect->prepare("SELECT ingredient_name, ingredient_quantity, ingredient_unit FROM ingredients WHERE ingredient_recipe_id = ?");
                        $ingredientQuery->bind_param('i', $id);
                        $ingredientQuery->execute();
                        $ingredientResult = $ingredientQuery->get_result();
                        ?>
                        <div class="recipe-box-title">
                            <h2><?php echo htmlspecialchars($recipe["recipe_name"]); ?></h2>
                            <i><?php echo $postedByName; ?></i>
                            <i class="bi bi-clock"><?php echo ' ' . htmlspecialchars($recipe["recipe_time"]) . ' minutes'; ?></i>
                        </div>
                        
                        <div class="recipe-box-detail">
                            <p>Nutritional Details / Recipe Description</p>
                            <p><?php echo htmlspecialchars($recipe["recipe_description"]); ?></p>
                        </div>

                        <div class="recipe-box-box">
                            <div class="recipe-box-box-box">
                                <div class="recipe-box-ingredients">
                                    <b>Ingredients</b>
                                    <ol>
                                        <?php
                                            if ($ingredientResult->num_rows > 0) {
                                                while ($ingredient = $ingredientResult->fetch_assoc()) {
                                                    echo '<li>' . htmlspecialchars($ingredient["ingredient_quantity"]) . ' ' . htmlspecialchars($ingredient["ingredient_unit"]) . ' ' . htmlspecialchars($ingredient["ingredient_name"]) . '</li>';
                                                }
                                            } else {
                                                echo '<li>No ingredients found</li>';
                                            }
                                        ?>
                                    </ol>             
                                </div>

                                <div class="recipe-box-procedures">
                                    <b>Procedures</b>
                                    <p><?php echo htmlspecialchars($recipe["recipe_procedures"]); ?></p>        
                                </div>

                                <div class="recipe-box-procedures" styles="max-width: 200px;">
                                    <b>Tags</b>
                                    <?php
                                        $tags = [];

                                        // Fetch the allergies for the given recipe
                                        $allergyQuery = $connect->prepare("SELECT allergy_name FROM allergies WHERE allergy_recipe_id = ?");
                                        $allergyQuery->bind_param('i', $id);
                                        $allergyQuery->execute();
                                        $allergyResult = $allergyQuery->get_result();

                                        if ($allergyResult->num_rows > 0) {
                                            while ($allergy = $allergyResult->fetch_assoc()) {
                                                $tags[] = htmlspecialchars($allergy["allergy_name"]);
                                            }
                                        }

                                        // Fetch the conditions for the given recipe
                                        $conditionQuery = $connect->prepare("SELECT condition_name FROM conditions WHERE condition_recipe_id = ?");
                                        $conditionQuery->bind_param('i', $id);
                                        $conditionQuery->execute();
                                        $conditionResult = $conditionQuery->get_result();

                                        if ($conditionResult->num_rows > 0) {
                                            while ($condition = $conditionResult->fetch_assoc()) {
                                                $tags[] = htmlspecialchars($condition["condition_name"]);
                                            }
                                        }

                                        // Fetch the considerations for the given recipe
                                        $considerationQuery = $connect->prepare("SELECT consideration_name FROM considerations WHERE consideration_recipe_id = ?");
                                        $considerationQuery->bind_param('i', $id);
                                        $considerationQuery->execute();
                                        $considerationResult = $considerationQuery->get_result();

                                        if ($considerationResult->num_rows > 0) {
                                            while ($consideration = $considerationResult->fetch_assoc()) {
                                                $tags[] = htmlspecialchars($consideration["consideration_name"]);
                                            }
                                        }

                                        if (count($tags) > 0) {
                                            echo '<p>#' . implode(' , #', $tags) . '</p>';
                                        } else {
                                            echo '<p>No tags found</p>';
                                        }
                                    ?>
                                </div>
                            </div>

                            <div class="recipe-box-image">
                                <img src='../images/<?php echo htmlspecialchars($recipe['recipe_image']); ?>' alt='<?php echo htmlspecialchars($recipe["recipe_name"]); ?>' style="max-width: 300px; max-height: 300px;">
                            </div>
                            
                        </div>
                        <?php
                    } else {
                        echo '<p style="background-color: white;">No recipes found</p>';
                    }
                } else {
                    echo 'Error: ' . $connect->error;
                }
            } else {
                echo 'Error preparing statement: ' . $connect->error;
            }
        } else {
            echo '<p>Invalid recipe ID.</p>';
        }
        mysqli_close($connect);
    ?>
    <div class="edit" style="background-color: white;">
        <a href="./recipe_edit.php?id=<?php echo htmlspecialchars($recipe['recipe_id']); ?>">
            <button id="recipe_edit" style="padding:10px 15px; background-color: #f2f2f2">Edit Recipe</button>
        </a>
    </div>
</div>
<?php include '../nav footer/chef_footer.php'; ?>    <!-- FOOTER -->

</body>
</html>
