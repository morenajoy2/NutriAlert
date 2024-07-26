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

// Handle form submission for adding considerations
if (isset($_POST["submit"])) {
    // Combine selected consideration or entered name
    $consideration_name = !empty($_POST['consideration']) ? $_POST['consideration'] : $_POST['name'];
    $consideration_recipe_id = $_POST['recipeID'];

    // Prepare SQL statement to insert data into considerations table
    $insertQuery = "INSERT INTO `considerations` (`consideration_name`, `consideration_recipe_id`) 
                    VALUES (?, ?)";

    if ($stmt = $connect->prepare($insertQuery)) {
        $stmt->bind_param("si", $consideration_name, $consideration_recipe_id);
        if ($stmt->execute()) {
            // Redirect back to the consideration management page with a success message
            $_SESSION['success_message'] = 'consideration Added Successfully';
            header("Location: ../chef/consideration_management.php");
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
<?php include "../nav footer/chef_nav.php"; ?>
<div class="admin-add">
    <h2>New Consideration</h2>
    <form action="" method="POST" autocomplete="on">
        <div class="form-group">
            <label for="consideration">Consideration</label>
            <select name="consideration">
                <option value="">-- Select Consideration Name --</option>
                <option value="No added sugar">No added sugar</option>
                <option value="No preservatives">No preservatives</option>
                <option value="Less sodium">Less sodium</option>
                <option value="No added peanuts">No added peanuts</option>
                <option value="No vegetables">No vegetables</option>
                <option value="A little bit spicy">A little bit spicy</option>
                <option value="Added light bits of mint">Added light bits of mint</option>
                <option value="Raw food">Raw food</option>
                <option value="More on meat">More on meat</option>
                <option value="Vegetarians">Vegetarians</option>
                <option value="Vegans">Vegans</option>
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
<?php include "../nav footer/chef_footer.php";?>
</body>
</html>
