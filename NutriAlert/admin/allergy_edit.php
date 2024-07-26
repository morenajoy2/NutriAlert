<?php 
    // session_start();
    include_once '../config/db_connection.php';
    $connect = mysqli_connect_mysql(); // Initialize the database connection

    // Ensure the id is an integer
    $id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

    // Prepare SQL statement
    $stmt = $connect->prepare("SELECT * FROM allergies WHERE allergy_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $name = $row["allergy_name"];
        $allergy_recipe_id = $row["allergy_recipe_id"];
    } else {
        echo '<p>Allergy not found.</p>';
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
            $selected = $row['recipe_id'] == $allergy_recipe_id ? ' selected' : '';
            $options[] = "<option value='{$row['recipe_id']}'{$selected}>{$row['recipe_name']}</option>";
        }
        // Free result set
        mysqli_free_result($result);
    } else {
        // Query failed
        echo "Error: " . mysqli_error($connect);
    }

    if (isset($_POST["submit"])) {
        $selected_allergy = $_POST['edit_allergy'];
        $new_name = !empty($_POST['name']) ? $_POST['name'] : $selected_allergy;
        $new_allergy_recipe_id = $_POST['recipeID'];

        // Prepare SQL statement to update allergy
        $updateStmt = $connect->prepare("UPDATE `allergies` 
            SET `allergy_name` = ?, `allergy_recipe_id` = ?
            WHERE `allergy_id` = ?");
        $updateStmt->bind_param("sii", $new_name, $new_allergy_recipe_id, $id);
        
        if($updateStmt->execute()) {
            echo "<script> alert('Allergy updated successfully.'); window.location.href='./allergy_management.php'; </script>";
        } else {
            echo "<script> alert('Failed to update allergy.'); </script>";
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
            var allergySelect = document.querySelector('select[name="edit_allergy"]');
            var othersField = document.querySelector('input[name="name"]');
            if (allergySelect.value !== "") {
                othersField.value = "";
                othersField.readOnly = true;
            } else {
                othersField.readOnly = false;
            }
        }
    </script>
</head>
<body>
<?php include "../nav footer/admin_nav.php"; ?>
<div class="admin-add">
    <h2>Edit Allergy</h2>
    <form action="" method="post" autocomplete="on">
        <div class="form-group">
            <label for="allergy">Allergy</label>
            <select name="edit_allergy" onchange="toggleOthersField()">
                <option value="">-- Select Allergy Name --</option>
                <option value="Gluten-Free" <?= $name == 'Gluten-Free' ? 'selected' : '' ?>>Gluten-Free</option>
                <option value="Lactose-Free" <?= $name == 'Lactose-Free' ? 'selected' : '' ?>>Lactose-Free</option>
                <option value="Salicylate" <?= $name == 'Salicylate' ? 'selected' : '' ?>>Salicylate</option>
                <option value="Sugar-Free" <?= $name == 'Sugar-Free' ? 'selected' : '' ?>>Sugar-Free</option>
                <option value="Egg-Free" <?= $name == 'Egg-Free' ? 'selected' : '' ?>>Egg-Free</option>
                <option value="Addictive-Free" <?= $name == 'Addictive-Free' ? 'selected' : '' ?>>Addictive-Free</option>
                <option value="Suphites-Free" <?= $name == 'Suphites-Free' ? 'selected' : '' ?>>Suphites-Free</option>
                <option value="Nut-Free" <?= $name == 'Nut-Free' ? 'selected' : '' ?>>Nut-Free</option>
                <option value="Shellfish-Free" <?= $name == 'Shellfish-Free' ? 'selected' : '' ?>>Shellfish-Free</option>
                <option value="Alcohol-Free" <?= $name == 'Alcohol-Free' ? 'selected' : '' ?>>Alcohol-Free</option>
                <option value="Histamine-Free" <?= $name == 'Histamine-Free' ? 'selected' : '' ?>>Histamine-Free</option>
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

<?php include "../nav footer/admin_footer.php"; ?>
<script>
    // Initialize the field state based on the current selection
    toggleOthersField();
</script>
</body>
</html>
