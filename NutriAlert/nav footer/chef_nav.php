<?php 
    // session_start();
    include_once '../config/db_connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriAlert</title>
    <link rel="stylesheet" href="../css/css.css">
</head>
<nav>
    <div class="nav">
        <h2>NutriAlert</h2>
        <div class="nav-a">
            <a href="./dashboard.php">Home</a>
            <a href="./recipe_management.php">Recipe</a>
            <a href="./ingredient_management.php">Ingredient</a>
            <a href="./allergy_management.php" >Allergy</a>
            <a href="./condition_management.php" >Condition</a>
            <a href="./consideration_management.php" >Consideration</a>
            <a href="./announcement_management.php">Announcement</a>
            <a href="./profile.php">Profile</a>
            <a href="../logout.php">Sign Out</a>
        </div>
    </div>
</nav>

