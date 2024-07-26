<?php 
    // session_start();
    include_once '../config/db_connection.php';
    $connect = mysqli_connect_mysql(); // Initialize the database connection

    // Ensure the id is an integer
    $id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

    // Prepare SQL statement
    $stmt = $connect->prepare("SELECT * FROM conditions WHERE condition_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $name = $row["condition_name"];
        $condition_recipe_id = $row["condition_recipe_id"];
    } else {
        echo '<p>Condition not found.</p>';
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
            $selected = $row['recipe_id'] == $condition_recipe_id ? ' selected' : '';
            $options[] = "<option value='{$row['recipe_id']}'{$selected}>{$row['recipe_name']}</option>";
        }
        // Free result set
        mysqli_free_result($result);
    } else {
        // Query failed
        echo "Error: " . mysqli_error($connect);
    }

    if (isset($_POST["submit"])) {
        $selected_condition = $_POST['edit_condition'];
        $new_name = !empty($_POST['name']) ? $_POST['name'] : $selected_condition;
        $new_condition_recipe_id = $_POST['recipeID'];

        // Prepare SQL statement to update condition
        $updateStmt = $connect->prepare("UPDATE `conditions` 
            SET `condition_name` = ?, `condition_recipe_id` = ?
            WHERE `condition_id` = ?");
        $updateStmt->bind_param("sii", $new_name, $new_condition_recipe_id, $id);
        
        if($updateStmt->execute()) {
            echo "<script> alert('Condition updated successfully.'); window.location.href='./condition_management.php'; </script>";
        } else {
            echo "<script> alert('Failed to update condition.'); </script>";
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
    <script>
        function toggleOthersField() {
            var conditionSelect = document.querySelector('select[name="edit_condition"]');
            var othersField = document.querySelector('input[name="name"]');
            if (conditionSelect.value !== "") {
                othersField.value = "";
                othersField.readOnly = true;
            } else {
                othersField.readOnly = false;
            }
        }
    </script>
</head>
<body>
<?php include "../nav footer/chef_nav.php"; ?>
<div class="admin-add">
    <h2>Edit Health Condition</h2>
    <form action="" method="post" autocomplete="on">
        <div class="form-group">
            <label for="condition">Health Condition</label>
            <select name="edit_condition" onchange="toggleOthersField()">
                <option value="">-- Select Health Condition Name --</option>
                <option value="Diabetes Friendly" <?= $name == 'Diabetes Friendly' ? 'selected' : '' ?>>Diabetes Friendly</option>
                <option value="CBD Friendly" <?= $name == 'CBD Friendly' ? 'selected' : '' ?>>CBD Friendly</option>
                <option value="Heart Condition" <?= $name == 'Heart Condition' ? 'selected' : '' ?>>Heart Condition</option>
                <option value="Chronic Condition" <?= $name == 'Chronic Condition' ? 'selected' : '' ?>>Chronic Condition</option>
                <option value="Stomach Condition" <?= $name == 'Stomach Condition' ? 'selected' : '' ?>>Stomach Condition</option>
            </select>
        </div>

        <div class="form-group">
            <label for="edit_name">Others</label> 
            <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>">
        </div>

        <div class="form-group">
            <label for="edit_recipeID">Recipe</label> 
            <select id="edit_recipeID" name="recipeID" required>
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
<script>
    // Initialize the field state based on the current selection
    toggleOthersField();
</script>
</body>
</html>
