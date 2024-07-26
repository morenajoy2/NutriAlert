<?php 
session_start();
include_once "../config/db_connection.php";
$connect = mysqli_connect_mysql(); // Initialize the database connection

// Fetch recipes for the dropdown
$query = "SELECT `recipe_id`, `recipe_name` FROM `recipes`";
$result = mysqli_query($connect, $query);

// Check if query was successful
if ($result) {
    // Initialize an array to store recipe options
    $options = array();

    // Fetch rows from the result set
    while ($row = mysqli_fetch_assoc($result)) {
        // Add recipe option to the array
        $options[] = "<option value='{$row['recipe_id']}'>{$row['recipe_name']}</option>";
    }
    // Free result set
    mysqli_free_result($result);
} else {
    // Query failed
    echo "Error: " . mysqli_error($connect);
}

// Handle form submission for adding ingredients
if (isset($_POST["submit"])) {
    // Combine selected ingredient or entered name
    $ingredient_name = !empty($_POST['ingredient']) ? $_POST['ingredient'] : $_POST['name'];
    $ingredient_recipe_id = $_POST['recipeID'];
    $quantity = $_POST['quantity'];
    $unit = $_POST['unit'];

    // Prepare SQL statement to insert data into ingredients table
        $insertQuery = "INSERT INTO `ingredients` (`ingredient_name`, `ingredient_quantity`, `ingredient_unit`, `ingredient_recipe_id`) 
                        VALUES (?, ?, ?, ?)";

    if ($stmt = $connect->prepare($insertQuery)) {
        $stmt->bind_param("sssi", $ingredient_name, $quantity, $unit, $ingredient_recipe_id);
        if ($stmt->execute()) {
            // Redirect back to the ingredient management page with a success message
            $_SESSION['success_message'] = 'Ingredient Added Successfully';
            header("Location: ../admin/ingredient_management.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Error: " . $connect->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriAlert</title>
    <link rel="stylesheet" href="../css/css.css">
</head>
<body>
<?php include "../nav footer/admin_nav.php"; ?>
<div class="admin-add">
    <h2>New Ingredient</h2>
    <form action="" method="POST" autocomplete="on">
        <div class="form-group">
            <label for="ingredient">Ingredient</label>
            <select name="ingredient">
                <option value="">-- Select Ingredient Name --</option>
                <option value="Apple">Apple</option>
                <option value="Mango">Mango</option>
                <option value="Bread">Bread</option>
                <option value="Truffle">Truffle</option>
                <option value="Egg">Egg</option>
                <option value="Pepper">Pepper</option>
                <option value="Carrot">Carrot</option>
                <option value="Onion">Onion</option>
                <option value="White Mushroom">White Mushroom</option>
                <option value="Black Olives">Black Olives</option>
                <option value="Condensed Milk">Condensed Milk</option>
                <option value="Yogurt">Yogurt</option>
                <option value="Potato">Potato</option>
                <option value="Tomato">Tomato</option>
                <option value="Kale">Kale</option>
                <option value="Flour">Flour</option>
            </select>
        </div>

        <div class="form-group">
            <label for="name">Others</label>
            <input type="text" id="name" name="name">
        </div>

        <div class="form-group">
            <label for="quantity">Quantity</label> 
            <input type="text" id="quantity" name="quantity" required>
        </div>

        <div class="form-group">
            <label for="unit">Unit</label> 
            <input type="text" id="unit" name="unit" required>
        </div>

        <div class="form-group">
            <label for="recipeID">Recipe</label> 
            <select name="recipeID" required>
                <option value="">-- Select Recipe Name --</option>
                <?php foreach ($options as $option) { echo $option; } ?>
            </select>
        </div>

        <div class="submit">
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            <button type="reset" name="reset" class="btn btn-secondary">Reset</button>
        </div>
    </form>
</div>
<?php include "../nav footer/admin_footer.php";?>
</body>
</html>
