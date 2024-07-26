<?php 
    // session_start();
    include_once '../config/db_connection.php';
    $connect = mysqli_connect_mysql(); // Initialize the database connection

    // Ensure the id is an integer
    $id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

    // Prepare SQL statement
    $stmt = $connect->prepare("SELECT * FROM ingredients WHERE ingredient_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $name = $row["ingredient_name"];
        $quantity = $row["ingredient_quantity"];
        $unit = $row["ingredient_unit"];
        $ingredient_recipe_id = $row["ingredient_recipe_id"];
    } else {
        echo '<p>Ingredient not found.</p>';
        exit();
    }

    // Query to fetch recipes
    $query = "SELECT `recipe_id`, `recipe_name` FROM `recipes`";
    $result = mysqli_query($connect, $query);

    // Check if query was successful
    if ($result) {
        // Initialize an array to store recipe options
        $options = array();

        // Fetch rows from the result set
        while ($row = mysqli_fetch_assoc($result)) {
            // Add recipe option to the array with selected attribute
            $selected = $row['recipe_id'] == $ingredient_recipe_id ? ' selected' : '';
            $options[] = "<option value='{$row['recipe_id']}'{$selected}>{$row['recipe_name']}</option>";
        }
        // Free result set
        mysqli_free_result($result);
    } else {
        // Query failed
        echo "Error: " . mysqli_error($connect);
    }

    if (isset($_POST["submit"])) {
        $new_name = $_POST['name'];
        $new_quantity = $_POST['quantity'];
        $new_unit = $_POST['unit'];
        $new_ingredient_recipe_id = $_POST['recipeID'];

        // Prepare SQL statement to update ingredient
        $updateStmt = $connect->prepare("UPDATE `ingredients` 
            SET `ingredient_name` = ?, 
                `ingredient_quantity` = ?, 
                `ingredient_unit` = ?, 
                `ingredient_recipe_id` = ?
            WHERE `ingredient_id` = ?");
        $updateStmt->bind_param("ssssi", $new_name, $new_quantity, $new_unit, $new_ingredient_recipe_id, $id);
        
        if($updateStmt->execute()) {
            echo "<script> alert('Ingredient updated successfully.'); window.location.href='./ingredient_management.php'; </script>";
        } else {
            echo "<script> alert('Failed to update ingredient.'); </script>";
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
<?php include "../nav footer/chef_nav.php"; ?>
<div class="admin-add">
    <h2>Edit Ingredient</h2>
    <form action="" method="post" autocomplete="on">
        <div class="form-group">
            <label for="edit_name">Name</label> 
            <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>">
        </div>

        <div class="form-group">
            <label for="edit_quantity">Quantity</label> 
            <input type="text" name="quantity" value="<?php echo htmlspecialchars($quantity); ?>">
        </div>

        <div class="form-group">
            <label for="edit_unit">Unit</label> 
            <input type="text" name="unit" value="<?php echo htmlspecialchars($unit); ?>">
        </div>

        <div class="form-group">
            <label for="edit_recipeID">Recipe</label> 
            <select id="edit_recipeID" name="recipeID" required >
                <?php foreach ($options as $option) { echo $option; } ?>
            </select>
        </div>

        <div class="submit">
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            <button type="reset" name="reset" class="btn btn-secondary">Reset</button>
        </div>
    </form>
</div>

<?php include "../nav footer/chef_footer.php"; ?>
</body>
</html>