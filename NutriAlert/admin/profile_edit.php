<?php
session_start();
include_once '../config/db_connection.php';
include '../nav footer/admin_nav.php'; // NAVIGATION

$connect = mysqli_connect_mysql(); // Initialize the database connection

$user_id = $_GET['id'];
$sql = "SELECT * FROM users WHERE user_id = ?";
$stmt = mysqli_prepare($connect, $sql);
mysqli_stmt_bind_param($stmt, 'i', $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_array($result);

if ($row) {
    // Assign user data to variables
    $first_name = $row['user_first_name'];
    $last_name = $row['user_last_name'];
    $username = $row['user_username'];
    $email = $row['user_email'];
    $password = $row['user_password'];
    $phone = $row['user_phone'];
    $weight = $row['user_weight'];
    $height = $row['user_height'];
    $bio = $row['user_bio'];
    $image = $row['user_image'];
} else {
    echo '<p class="error-message">User not found.</p>';
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Sanitize and validate input data
    $new_first_name = $_POST['firstname'];
    $new_last_name = $_POST['lastname'];
    $new_username = $_POST['username'];
    $new_email = $_POST['email'];
    $new_password = $_POST['password'];
    $new_phone = $_POST['phone'];
    $new_weight = $_POST['weight'];
    $new_height = $_POST['height'];
    $new_bio = $_POST['bio'];

    // Handle image upload
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
    } else {
        $target_file = $image; // Keep the old image if no new image is uploaded
    }

    // Update user data
    $update_sql = "UPDATE users 
                    SET user_first_name = ?, 
                        user_last_name = ?, 
                        user_username = ?, 
                        user_email = ?, 
                        user_password = ?, 
                        user_phone = ?, 
                        user_weight = ?, 
                        user_height = ?, 
                        user_bio = ?, 
                        user_image = ? 
                    WHERE user_id = ?";
    $update_stmt = mysqli_prepare($connect, $update_sql);
    mysqli_stmt_bind_param($update_stmt, 'ssssssssssi', $new_first_name, $new_last_name, $new_username, $new_email, $new_password, $new_phone, $new_weight, $new_height, $new_bio, $target_file, $user_id);

    if (mysqli_stmt_execute($update_stmt)) {
        echo '<script>alert("Profile updated successfully."); window.location.href = "../admin/user_management.php";</script>';
        exit();
    } else {
        echo '<p class="error-message">Failed to update profile information.</p>';
    }

    mysqli_stmt_close($update_stmt);
    $connect->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriAlert - Edit Profile</title>
    <link rel="stylesheet" href="../css/css.css">
</head>
<body>
    <div class="admin-add">
        <h2>Edit Profile</h2>
        <form action="" method="POST" enctype="multipart/form-data" autocomplete="on">
            <div class="form-group">
                <label for="firstname">First Name</label>
                <input type="text" id="firstname" name="firstname" value="<?= $first_name ?>" required>
            </div>
            <div class="form-group">
                <label for="lastname">Last Name</label>
                <input type="text" id="lastname" name="lastname" value="<?= $last_name ?>" required>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?= $username ?>" required>
            </div>
            <div class="form-group">
                <label for="weight">Weight (kg)</label>
                <input type="number" id="weight" name="weight" value="<?= $weight ?>">
            </div>
            <div class="form-group">
                <label for="height">Height (inch)</label>
                <input type="number" id="height" name="height" value="<?= $height ?>">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= $email ?>">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="text" id="password" name="password" value="<?= $password ?>">
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone" value="<?= $phone ?>">
            </div>
            <div class="form-group">
                <label for="bio">Bio</label>
                <textarea id="bio" name="bio" required><?= $bio ?></textarea>
            </div>
            <div class="form-group">
                <label for="image">Profile Picture</label>
                <img src="../images/<?= $image ?>" alt="Profile Image" style="max-width: 200px; max-height: 200px; margin-right:10px;">
                <input type="file" id="image" name="image">
            </div>
            <div class="submit">
                <button type="submit" name="submit">Submit</button>
                <button type="reset" name="reset">Reset</button>
            </div>
        </form>
    </div>
    <?php include '../nav footer/admin_footer.php'; ?>    <!-- FOOTER -->

</body>
</html>
