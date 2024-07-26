<?php 
include_once '../config/db_connection.php';
$connect = mysqli_connect_mysql(); // Initialize the database connection

$id = $_GET["id"];

// Prepare the SELECT statement to fetch the recipe data
$stmt = $connect->prepare("SELECT * FROM recipes WHERE recipe_id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row) {
    $name = $row["recipe_name"];
    $time = $row['recipe_time'];
    $image = $row['recipe_image'];
    $description = $row['recipe_description']; 
    $procedures = $row['recipe_procedures'];
} else {
    echo '<script>alert("Recipe not found.")</script>';
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $new_name = $_POST['name'];
    $new_time = $_POST['time'];
    $new_description = $_POST['description']; 
    $new_procedures = $_POST['procedures'];

    // Handle image upload
    $new_image = $image; // Default to old image if no new image is uploaded
    if ($_FILES['image']['name']) {
        $new_image = $_FILES['image']['name'];
        $target_dir = "../images/";
        $target_file = $target_dir . basename($new_image);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $uploadOk = 1;

        // Check if image file is an actual image or fake image
        $check = getimagesize($_FILES['image']['tmp_name']);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo '<script>alert("File is not an image.")</script>';
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            echo '<script>alert("Sorry, file already exists.")</script>';
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES['image']['size'] > 500000) {
            echo '<script>alert("Sorry, your file is too large.")</script>';
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo '<script>alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.")</script>';
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo '<script>alert("Sorry, your file was not uploaded.")</script>';
        } else {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                echo '<script>alert("The file ' . basename($new_image) . ' has been uploaded.")</script>';
            } else {
                echo '<script>alert("Sorry, there was an error uploading your file.")</script>';
                // Print out more detailed error information
                error_log("File upload error: " . print_r(error_get_last(), true));
            }
        }
    }
    
    // Prepare the UPDATE statement to update the recipe data
    $update_query = "UPDATE recipes SET
                        recipe_name = ?,
                        recipe_time = ?,
                        recipe_image = ?,
                        recipe_description = ?,
                        recipe_procedures = ?
                    WHERE recipe_id = ?";
    $stmt = $connect->prepare($update_query);
    $stmt->bind_param('sisssi', $new_name, $new_time, $new_image, $new_description, $new_procedures, $id);

    if ($stmt->execute()) {
        echo "<script> 
                alert('Recipe updated successfully.'); 
                window.location.href='./recipe_management.php'; 
              </script>";
    } else {
        echo "<script> alert('Failed to update recipe.'); </script>";
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
    <h2>Edit Recipe</h2>
    <form action="" method="post" autocomplete="on" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" value="<?php echo $name; ?>" required>
        </div>

        <div class="form-group">
            <label for="time">Time</label>
            <input type="number" name="time" value="<?php echo $time; ?>" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" required><?php echo $description; ?></textarea>
        </div>

        <div class="form-group">
            <label for="procedures">Procedures</label>
            <textarea name="procedures" required><?php echo $procedures; ?></textarea>
        </div>

        <div class="form-group">
            <label for="image">Image</label>
            <img src="../images/<?php echo $image; ?>" alt="Profile Image" style="max-width: 200px; max-height: 200px; margin-right:10px;">
            <input type="file" name="image">
        </div>

        <div class="submit">
            <button type="submit" name="submit">Submit</button>
            <button type="reset" name="reset">Reset</button>
        </div>
    </form>
</div>
<?php include "../nav footer/admin_footer.php"; ?>
</body>
</html>
