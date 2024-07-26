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
<nav>
    <div class="nav">
        <h2>NutriAlert</h2>
        <div class="search">
            <div class="search-container">
                <form action="search.php" method="GET">
                    <i class="bi bi-search"><input type="search" id="search-input" name="query"></i>
                    <button type="submit" id="search">Search</button>
                    <a href="dashboard.php"><i class="bi bi-funnel-fill"></i></a>
                </form>
            </div>
        </div>
        <div class="nav-a">
            <a href="dashboard.php">Home</a>
            <a href="announcement.php">Announcement</a>
            <a href="profile.php">Profile</a>
            <a href="logout.php">Sign Out</a>
        </div>
    </div>
</nav>
<?php 

    // session_start();
    include_once './config/db_connection.php'; // Database connection
    $mysqli = mysqli_connect_mysql(); // Initialize the database connection
?>
    <div class="filter-box">
        
        <form action="search.php" method="GET">
		<div class="filter-button-button">
            <button type="submit" style="padding: 10px; background-color: darkgrey; margin-top: 10px; color: white; border-radius: 10px;">Filter</button>
        </div>
            <div class="filter-box-box">
                <div class="filter-box-box-1">
                    Ingredients:

                    <div class="filter-button">
                        <!-- <button type="button" class="button-value">All</button> -->
						<input type="checkbox" name="ingredients[]" value="Apple" id="apple"/>
                        <label for="apple">Apple</label>
						<input type="checkbox" name="ingredients[]" value="Mango" id="mango"/>
						<label for="mango">Mango</label>
						<input type="checkbox" name="ingredients[]" value="Bread" id="bread"/>
						<label for="bread">Bread</label>
						<input type="checkbox" name="ingredients[]" value="Truffle" id="truffle"/>
						<label for="truffle">Truffle</label>
                        <input type="checkbox" name="ingredients[]" value="Egg" id="egg"/>
						<label for="egg">Egg</label>
                        <input type="checkbox" name="ingredients[]" value="Pepper" id="pepper"/>
						<label for="pepper">Pepper</label>
                        <input type="checkbox" name="ingredients[]" value="Carrot" id="carrot"/>
						<label for="carrot">Carrot</label>
                        <input type="checkbox" name="ingredients[]" value="Onion" id="onion"/>
						<label for="onion">Onion</label>
                        <input type="checkbox" name="ingredients[]" value="White Mushroom" id="whitemushroom"/>
						<label for="whitemushroom">White Mushroom</label>
                        <input type="checkbox" name="ingredients[]" value="Black Olives" id="blackolives"/>
						<label for="blackolives">Black Olives</label>
                        <input type="checkbox" name="ingredients[]" value="Condensed Milk" id="condensedmilk"/>
						<label for="condensedmilk">Condensed Milk</label>
                        <input type="checkbox" name="ingredients[]" value="Yogurt" id="yogurt"/>
						<label for="yogurt">Yogurt</label>
                        <input type="checkbox" name="ingredients[]" value="Potato" id="potato"/>
						<label for="potato">Potato</label>
                        <input type="checkbox" name="ingredients[]" value="Tomato" id="tomato"/>
						<label for="tomato">Tomato</label>
                        <input type="checkbox" name="ingredients[]" value="Kale" id="kale"/>
						<label for="kale">Kale</label>
                        <input type="checkbox" name="ingredients[]" value="Flour" id="flour"/>
						<label for="flour">Flour</label>
                        <a href="#" style="background-color:white;">View More</a>
                    </div>
                </div>

                <div class="filter-box-box-1">
                    Allergies:
                    <div class="filter-button">
						<!-- <button type="button" class="button-value">All</button> -->
						<input type="checkbox" name="allergies[]" value="Gluten-Free" id="glutenfree"/>
                        <label for="glutenfree">Gluten-Free</label>
						<input type="checkbox" name="allergies[]" value="Lactose-Free" id="lactosefree"/>
                        <label for="lactosefree">Lactose-Free</label>
						<input type="checkbox" name="allergies[]" value="Salicylate" id="salicylate"/>
                        <label for="salicylatefree">Salicylate-Free</label>
						<input type="checkbox" name="allergies[]" value="Sugar-Free" id="sugarfree"/>
                        <label for="sugarfree">Sugar-Free</label>
						<input type="checkbox" name="allergies[]" value="Caffeine-Free" id="caffeinefree"/>
                        <label for="caffeinefree">Caffeine-Free</label>
						<input type="checkbox" name="allergies[]" value="Egg-free" id="eggfree"/>
                        <label for="eggfree">Egg-Free</label>
						<input type="checkbox" name="allergies[]" value="Addictive-free" id="addictivefree"/>
                        <label for="addictivefree">Addictive-Free</label>
						<input type="checkbox" name="allergies[]" value="Suphites-free" id="suphitesfree"/>
                        <label for="suphitesfree">Suphites-Free</label>
						<input type="checkbox" name="allergies[]" value="Nut-free" id="nutfree"/>
                        <label for="nutfree">Nut-Free</label>
						<input type="checkbox" name="allergies[]" value="Shellfish-free" id="shellfishfree"/>
                        <label for="shellfishfree">Shellfish-Free</label>
						<input type="checkbox" name="allergies[]" value="Alcohol-free" id="alcoholfree"/>
                        <label for="alcoholfree">Alcohol-Free</label>
						<input type="checkbox" name="allergies[]" value="Histamine-free" id="histaminefree"/>
                        <label for="histaminefree">Histamine-Free</label>
                        <a href="#" style="background-color:white;">View More</a>
                    </div>
                </div>
            </div>
            
            <div class="filter-box-box">
                <div class="filter-box-box-2">
                    Health Conditions:
                    <div class="filter-button">
						<input type="checkbox" name="conditions[]" value="Diabetes Friendly" id="diabetesFriendly"/>
                        <label for="diabetesFriendly">Diabetes Friendly</label>
						<input type="checkbox" name="conditions[]" value="CBD Friendly" id="CBDFriendly"/>
                        <label for="CBDFriendly">CBD Friendly</label>
						<input type="checkbox" name="conditions[]" value="Heart Condition" id="heartCondition"/>
                        <label for="heartCondition">Heart Condition</label>
						<input type="checkbox" name="conditions[]" value="Chronic Condition" id="chronicCondition"/>
                        <label for="chronicCondition">Chronic Condition</label>
						<input type="checkbox" name="conditions[]" value="Stomach Condition" id="stomachCondition"/>
                        <label for="stomachCondition">Stomach Condition</label>
						<a href="#" style="background-color:white;">View More</a>
                    </div>
                </div>

                <div class="filter-box-box-2">
                    Other Considerations:
                    <div class="filter-button">
						<input type="checkbox" name="considerations[]" value="No added sugar" id="noAddedSugar"/>
                        <label for="noAddedSugar">No added sugar</label>
						<input type="checkbox" name="considerations[]" value="No preservatives" id="noPreservatives"/>
                        <label for="noPreservatives">No preservatives</label>
						<input type="checkbox" name="considerations[]" value="Less sodium" id="lessSodium"/>
                        <label for="lessSodium">Less sodium</label>
						<input type="checkbox" name="considerations[]" value="No added peanuts" id="noAddedPeanuts"/>
                        <label for="noAddedPeanuts">No added peanuts</label>
						<input type="checkbox" name="considerations[]" value="No vegetables" id="noVegetables"/>
                        <label for="noVegetables">No vegetables</label>
						<input type="checkbox" name="considerations[]" value="A little bit spicy" id="littleSpicy"/>
                        <label for="littleSpicy">A little bit spicy</label>
						<input type="checkbox" name="considerations[]" value="Added light bits of mint" id="lightBitsMint"/>
                        <label for="lightBitsMint">Added light bits of mint</label>
						<input type="checkbox" name="considerations[]" value="Raw food" id="rawFood"/>
                        <label for="rawFood">Raw food</label>
						<input type="checkbox" name="considerations[]" value="More on meat" id="meaty"/>
                        <label for="meaty">More on meat</label>
						<input type="checkbox" name="considerations[]" value="Vegetarians" id="vegetarian"/>
                        <label for="vegetarian">Vegetarians</label>
						<input type="checkbox" name="considerations[]" value="Vegans" id="vegan"/>
                        <label for="vegan">Vegans</label>
						<a href="#" style="background-color:white;">View More</a>
                    </div>
                </div>
            </div>

        </form>
    </div>

    <?php include './nav footer/user_footer.php'; ?>    <!-- FOOTER -->
</body>
</html>
