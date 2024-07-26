<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriAlert</title>
    <link rel="stylesheet" href="../css/css.css">
</head>
<body>
<?php     
session_start();
include_once "../config/db_connection.php";
include '../nav footer/chef_nav.php';  // NAVIGATION

$connect = mysqli_connect_mysql(); // Initialize the database connection


if (isset($_SESSION['user_firstname']) && isset($_SESSION['user_lastname'])) {
    $chef_name = $_SESSION['user_firstname'] . ' ' . $_SESSION['user_lastname'];
} else {
    $chef_name = 'Unknown Name';
}
?>  

<div id="dashboard-box">
    <h2>Dashboard Overview</h2>
    <br/>
    <?php 

    $user = "SELECT * from users";
    $query = mysqli_query($connect, $user);
    $row = $query->fetch_assoc();
    ?>
    <h3>Hello, Chef 
        <?php echo $chef_name; ?>
    </h3>

    <div id="dashboard-box-total">
        <!-- Card body -->
        <div class="card-body">
            <div class="card-body-body">
                <div class="card-body-title">
                    <b>Total Users</b>
                </div>
                <div class="card-body-subtitle">
                    <?php
                    $user_type_select = "SELECT * from users WHERE user_type='user'";
                    $user_query = mysqli_query($connect, $user_type_select);
                    if($user_total = mysqli_num_rows($user_query)) {
                        echo $user_total;
                    } else {
                        echo 0;
                    }
                    ?>
                </div>
            </div>

            <div class="card-body-body">
                <div class="card-body-title">
                    <b>Total Chefs</b>
                </div>
                <div class="card-body-subtitle">
                    <?php
                    $chef_type_select = "SELECT * from users WHERE user_type='chef'";
                    $user_query = mysqli_query($connect, $chef_type_select);
                    if($user_total = mysqli_num_rows($user_query)) {
                        echo $user_total;
                    } else {
                        echo 0;
                    }
                    ?>
                </div>
            </div>

            <div class="card-body-body">
                <div class="card-body-title">
                    <b>Total Recipes</b>
                </div>
                <div class="card-body-subtitle">
                    <?php
                    $recipe = "SELECT * from recipes";
                    $recipe_query = mysqli_query($connect, $recipe);

                    if($recipe_total = mysqli_num_rows($recipe_query)) {
                        echo $recipe_total;
                    } else {
                        echo 0;
                    }
                    ?>
                </div>
            </div>

            <div class="card-body-body">
                <div class="card-body-title">
                    <b>Total Ingredients</b>
                </div>
                <div class="card-body-subtitle">
                    <?php
                    $ingredient = "SELECT * from ingredients";
                    $ingredient_query = mysqli_query($connect, $ingredient);

                    if($ingredient_total = mysqli_num_rows($ingredient_query)) {
                        echo $ingredient_total;
                    } else {
                        echo 0;
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include '../nav footer/chef_footer.php'; ?>    <!-- FOOTER -->

</body>
</html>
