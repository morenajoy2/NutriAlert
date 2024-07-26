<?php 
session_start(); // Start the session
include_once '../config/db_connection.php'; // Database connection
include '../nav footer/chef_nav.php'; // NAVIGATION

$connect = mysqli_connect_mysql(); // Initialize the database connection

// Ensure user_id is set and is an integer
$user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;
if ($user_id == 0) {
    echo '<p class="error-message">Invalid user ID.</p>';
    exit();
}

$sql = "SELECT * FROM users WHERE user_id = ?";
$stmt = $connect->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row) {
    $first_name = $row['user_first_name'];
    $last_name = $row['user_last_name'];
    $username = $row['user_username'];
    $weight = $row['user_weight'];
    $height = $row['user_height'];
    $email = $row['user_email'];
    $password = $row['user_password'];
    $phonenumber = $row['user_phone'];
    $bio = $row['user_bio'];
    $current_image = $row['user_image']; // Assuming the column for the image is `user_image`
} else {
    echo '<p class="error-message">User not found.</p>';
    exit();
}

if(isset($_POST["submit"])) {
    $new_firstname = $_POST["firstname"];
    $new_lastname = $_POST["lastname"];
    $new_username = $_POST["username"];
    $new_weight = $_POST["weight"];
    $new_height = $_POST["height"];
    $new_email = $_POST["email"];
    $new_password = $_POST["password"];
    $new_phonenumber = $_POST["phone"];
    $new_bio = $_POST["bio"];

    // Handle image upload
    $new_image = $current_image; // Default to current image
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image']['name'];
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
                $new_image = basename($image); // Update with new image name
            } else {
                echo '<script>alert("Sorry, there was an error uploading your file.")</script>';
            }        
        }
    }

    // Update user profile
    $update_query = "UPDATE users SET 
        user_first_name = ?, 
        user_last_name = ?, 
        user_username = ?, 
        user_weight = ?, 
        user_height = ?, 
        user_email = ?, 
        user_password = ?, 
        user_phone = ?, 
        user_bio = ?, 
        user_image = ? 
        WHERE user_id = ?";

    $stmt = $connect->prepare($update_query);
    $stmt->bind_param("sssiississi", 
        $new_firstname, $new_lastname, $new_username, 
        $new_weight, $new_height, $new_email, 
        $new_password, $new_phonenumber, $new_bio, 
        $new_image, $user_id);

    if ($stmt->execute()) {
        echo "<script> alert('Profile updated successfully'); window.location.href='profile.php'; </script>";
    } else {
        echo "<script> alert('Failed to update profile: " . $stmt->error . "') </script>";
    }
    $stmt->close();
}
$connect->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriAlert</title>
    <link rel="stylesheet" href="../css/css.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <div class="admin-add">
        <h2>Edit Profile</h2>
        <form action="" method="POST" enctype="multipart/form-data" autocomplete="on">
            <div class="form-group">
                <label for="firstname">First Name</label>
                <input type="text" id="firstname" name="firstname" value="<?= htmlspecialchars($first_name) ?>" required>
            </div>
            <div class="form-group">
                <label for="lastname">Last Name</label>
                <input type="text" id="lastname" name="lastname" value="<?= htmlspecialchars($last_name) ?>" required>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?= htmlspecialchars($username) ?>" required>
            </div>
            <div class="form-group">
                <label for="weight">Weight (kg)</label>
                <input type="number" id="weight" name="weight" value="<?= htmlspecialchars($weight) ?>">
            </div>
            <div class="form-group">
                <label for="height">Height (inch)</label>
                <input type="number" id="height" name="height" value="<?= htmlspecialchars($height) ?>">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" value="<?= htmlspecialchars($password) ?>">
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($phonenumber) ?>">
            </div>
            <div class="form-group">
                <label for="bio">Bio</label>
                <textarea id="bio" name="bio" required><?= htmlspecialchars($bio) ?></textarea>
            </div>
            <div class="form-group">
                <label for="image">Profile Picture</label>
                <img src="../images/<?= $current_image ?>" alt="Profile Image" style="max-width: 200px; max-height: 200px; margin-right:10px;">
                <input type="file" id="image" name="image">
            </div>
            <div class="submit">
                <button type="submit" name="submit">Submit</button>
                <button type="reset" name="reset">Reset</button>
            </div>
        </form>
    </div>
    <?php include '../nav footer/chef_footer.php'; ?>    <!-- FOOTER -->
</body>
</html>
