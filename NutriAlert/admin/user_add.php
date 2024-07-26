<?php
session_start(); // Start the session
include_once "../config/db_connection.php";
$connect = mysqli_connect_mysql(); // Initialize the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $usertype = $_POST['usertype'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $birthday = $_POST['birthday'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $weight = $_POST['weight'];
    $height = $_POST['height'];
    $email = $_POST['email'];
    $password = $_POST['password']; 
    $phone = $_POST['phone'];
    $bio = $_POST['bio'];
    $image = $_FILES['image']['name'];

    // Image upload
    $target_dir = "../images/";
    $target_file = $target_dir . basename($image);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $uploadOk = 1;

    if ($image) {
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
            echo '<script>alert("Sorry, file already exists. Try change your file name.")</script>';
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
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                echo '<script>alert("The file '. basename($image) .' has been uploaded.")</script>';
            } else {
                echo '<script>alert("Sorry, there was an error uploading your file.")</script>';
            }
        }
    } else {
        $target_file = null; // Handle case where no file is uploaded
    }

    if ($uploadOk == 1 || $target_file === null) {
        $stmt = $connect->prepare("INSERT INTO users (user_type, user_first_name, user_last_name, user_username, user_birthday, user_age, user_gender, user_weight, user_height, user_email, user_password, user_phone, user_bio, user_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssisissssss", $usertype, $firstname, $lastname, $username, $birthday, $age, $gender, $weight, $height, $email, $password, $phone, $bio, $target_file);

        if ($stmt->execute()) {
            echo '<script>alert("New record created successfully"); window.location.href="../admin/user_management.php";</script>';
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
<?php include "../nav footer/admin_nav.php"; ?>
<div class="admin-add">
    <h2>New User</h2>
    <form action="" method="POST" enctype="multipart/form-data" autocomplete="on">
        <div class="form-group">
            <label for="usertype">User Type</label> 
            <select id="usertype" name="usertype" required>
                <option value="">--Select a user type--</option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
                <option value="chef">Chef</option>
            </select>
        </div>

        <div class="form-group">
            <label for="firstname">First Name</label> 
            <input type="text" id="firstname" name="firstname" required>
        </div>

        <div class="form-group">
            <label for="lastname">Last Name</label> 
            <input type="text" id="lastname" name="lastname" required>
        </div>

        <div class="form-group">
            <label for="username">Username</label> 
            <input type="text" id="username" name="username" required>
        </div>

        <div class="form-group">
            <label for="birthday">Birthday</label> 
            <input type="date" id="birthday" name="birthday" required>
        </div>

        <div class="form-group">
            <label for="age">Age</label> 
            <input type="number" id="age" name="age" required>
        </div>

        <div class="form-group">
            <label for="gender">Gender</label> 
            <select id="gender" name="gender" required>
                <option value="">--Select a gender--</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>

        <div class="form-group">
            <label for="weight">Weight (kg or lbs)</label>
            <input type="number" id="weight" name="weight" required>
        </div>

        <div class="form-group">
            <label for="height">Height (cm or inch)</label>
            <input type="number" id="height" name="height" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label> 
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="number" id="phone" name="phone" required>
        </div>
        
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" id="image" name="image" accept="image/*">
        </div>

        <div class="form-group">
            <label for="bio">Bio</label>
            <textarea id="bio" name="bio" required></textarea>
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
