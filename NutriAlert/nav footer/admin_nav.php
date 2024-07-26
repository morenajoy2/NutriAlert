<?php 
    // session_start();
    include_once '../config/db_connection.php';
?>
<nav>
    <div class="nav">
        <h2>NutriAlert</h2>
        <div class="nav-a">
            <a href="./dashboard.php">Home</a>
            <a href="./user_management.php" >User</a>
            <a href="./recipe_management.php" >Recipe</a>
            <a href="./ingredient_management.php" >Ingredient</a>
            <a href="./allergy_management.php" >Allergy</a>
            <a href="./condition_management.php" >Condition</a>
            <a href="./consideration_management.php" >Consideration</a>
            <a href="./announcement_management.php" >Announcement</a>
            <a href="../logout.php">Sign Out</a>
        </div>
    </div>
</nav>