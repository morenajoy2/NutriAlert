<?php 
session_start();

include_once '../config/db_connection.php';
$connect = mysqli_connect_mysql(); // Initialize the database connection

if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if the user is not logged in
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // Get the logged-in user's ID

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $name = $_POST['name'];
    $time = $_POST['time'];
    $image = $_FILES['image']['name'];
    $description = $_POST['description']; 
    $procedures = $_POST['procedures'];

    $target_dir = "../images/";
    $target_file = $target_dir . basename($image);
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
        echo '<script>alert("Sorry, file already exists. Try changing your file name.")</script>';
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES['image']['size'] > 10000000) {
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
            echo '<script>alert("The file ' . basename($image) . ' has been uploaded.")</script>';
        } else {
            echo '<script>alert("Sorry, there was an error uploading your file.")</script>';
        }        
    }

    if ($uploadOk == 1) {
        $stmt = $connect->prepare("INSERT INTO `recipes`(`recipe_name`, `recipe_time`, `recipe_description`, `recipe_procedures`, `recipe_image`, `recipe_posted_by_id`) VALUES (?, ?, ?, ?, ?, ?)");
        // Bind parameters (s = string, i = integer)
        $stmt->bind_param("sssssi", $name, $time, $description, $procedures, $target_file, $user_id);

        if ($stmt->execute()) {
            echo '<script>alert("New record created successfully")</script>';
            header("Location: ../chef/recipe_management.php");
            exit();
        } else {
            echo '<script>alert("Error: ' . $stmt->error . '")</script>';
        }
        $stmt->close();
    }
    $connect->close();
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
    <h2>New Recipe</h2>
    <form action="" method="POST" autocomplete="on" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" required>
        </div>

        <div class="form-group">
            <label for="time">Time</label>
            <input type="number" name="time" required>
        </div>
        
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" required></textarea>
        </div>

        <div class="form-group">
            <label for="procedures">Procedures</label>
            <textarea name="procedures" required></textarea>
        </div>

        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" required>
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
