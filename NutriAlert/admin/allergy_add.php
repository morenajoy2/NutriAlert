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

// Handle form submission for adding allergies
if (isset($_POST["submit"])) {
    // Combine selected allergy or entered name
    $allergy_name = !empty($_POST['allergy']) ? $_POST['allergy'] : $_POST['name'];
    $allergy_recipe_id = $_POST['recipeID'];

    // Prepare SQL statement to insert data into allergies table
    $insertQuery = "INSERT INTO `allergies` (`allergy_name`, `allergy_recipe_id`) 
                    VALUES (?, ?)";

    if ($stmt = $connect->prepare($insertQuery)) {
        $stmt->bind_param("si", $allergy_name, $allergy_recipe_id);
        if ($stmt->execute()) {
            // Redirect back to the allergy management page with a success message
            $_SESSION['success_message'] = 'Allergy Added Successfully';
            header("Location: ../admin/allergy_management.php");
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
    <h2>New Allergy</h2>
    <form action="" method="POST" autocomplete="on">
        <div class="form-group">
            <label for="allergy">Select Allergy</label>
            <select name="allergy">
                <option value="">-- Select Allergy Name --</option>
                <option value="Gluten-Free">Gluten-Free</option>
                <option value="Lactose-Free">Lactose-Free</option>
                <option value="Salicylate">Salicylate</option>
                <option value="Sugar-Free">Sugar-Free</option>
                <option value="Egg-Free">Egg-Free</option>
                <option value="Addictive-Free">Addictive-Free</option>
                <option value="Suphites-Free">Suphites-Free</option>
                <option value="Nut-Free">Nut-Free</option>
                <option value="Shellfish-Free">Shellfish-Free</option>
                <option value="Alcohol-Free">Alcohol-Free</option>
                <option value="Histamine-Free">Histamine-Free</option>
            </select>
        </div>

        <div class="form-group">
            <label for="name">Others</label>
            <input type="text" id="name" name="name">
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
