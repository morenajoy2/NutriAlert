<?php 
    // session_start();
    include_once '../config/db_connection.php';
    $connect = mysqli_connect_mysql(); // Initialize the database connection

    // Ensure the id is an integer
    $id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

    // Prepare SQL statement
    $stmt = $connect->prepare("SELECT * FROM considerations WHERE consideration_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $name = $row["consideration_name"];
        $consideration_recipe_id = $row["consideration_recipe_id"];
    } else {
        echo '<p>Consideration not found.</p>';
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
            $selected = $row['recipe_id'] == $consideration_recipe_id ? ' selected' : '';
            $options[] = "<option value='{$row['recipe_id']}'{$selected}>{$row['recipe_name']}</option>";
        }
        // Free result set
        mysqli_free_result($result);
    } else {
        // Query failed
        echo "Error: " . mysqli_error($connect);
    }

    if (isset($_POST["submit"])) {
        $selected_consideration = $_POST['edit_consideration'];
        $new_name = !empty($_POST['name']) ? $_POST['name'] : $selected_consideration;
        $new_consideration_recipe_id = $_POST['recipeID'];

        // Prepare SQL statement to update consideration
        $updateStmt = $connect->prepare("UPDATE `considerations` 
            SET `consideration_name` = ?, `consideration_recipe_id` = ?
            WHERE `consideration_id` = ?");
        $updateStmt->bind_param("sii", $new_name, $new_consideration_recipe_id, $id);
        
        if($updateStmt->execute()) {
            echo "<script> alert('Consideration updated successfully.'); window.location.href='./consideration_management.php'; </script>";
        } else {
            echo "<script> alert('Failed to update consideration.'); </script>";
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
            var considerationSelect = document.querySelector('select[name="edit_consideration"]');
            var othersField = document.querySelector('input[name="name"]');
            if (considerationSelect.value !== "") {
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
    <h2>Edit Consideration</h2>
    <form action="" method="post" autocomplete="on">
        <div class="form-group">
            <label for="consideration">Consideration</label>
            <select name="edit_consideration" onchange="toggleOthersField()">
            <option value="">-- Select Consideration Name --</option>
                <option value="No added sugar" <?= $name == 'No added sugar' ? 'selected' : '' ?>>No added sugar</option>
                <option value="No preservatives" <?= $name == 'No preservatives' ? 'selected' : '' ?>>No preservatives</option>
                <option value="Less sodium" <?= $name == 'Less sodium' ? 'selected' : '' ?>>Less sodium</option>
                <option value="No added peanuts" <?= $name == 'No added peanuts' ? 'selected' : '' ?>>No added peanuts</option>
                <option value="No vegetables" <?= $name == 'No vegetables' ? 'selected' : '' ?>>No vegetables</option>
                <option value="A little bit spicy" <?= $name == 'A little bit spicy' ? 'selected' : '' ?>>A little bit spicy</option>
                <option value="Added light bits of mint" <?= $name == 'Added light bits of mint' ? 'selected' : '' ?>>Added light bits of mint</option>
                <option value="Raw food" <?= $name == 'Raw food' ? 'selected' : '' ?>>Raw food</option>
                <option value="More on meat" <?= $name == 'More on meat' ? 'selected' : '' ?>>More on meat</option>
                <option value="Vegetarians" <?= $name == 'Vegetarians' ? 'selected' : '' ?>>Vegetarians</option>
                <option value="Vegans" <?= $name == 'Vegans' ? 'selected' : '' ?>>Vegans</option>
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
