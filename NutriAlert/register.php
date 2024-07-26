<?php
session_start();
include_once './config/db_connection.php';
$mysqli = mysqli_connect_mysql(); // Initialize the database connection

if (isset($_POST["submit"])) {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $username = $_POST["username"];
    $birthday = $_POST["birthday"];
    $age = $_POST["age"];
    $gender = $_POST["gender"];
    $weight = $_POST["weight"];
    $height = $_POST["height"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
    $phonenumber = $_POST["phone"];
    $user_bio = ""; // default empty bio
    $user_image = ""; // default empty image

    // Check for duplicate email or username
    $duplicate = mysqli_query($mysqli, "SELECT * FROM users WHERE user_email = '$email' OR user_username = '$username'");

    if (mysqli_num_rows($duplicate) > 0) {
        echo "<script> alert('Email or Username has already been taken'); </script>";
    } else {
        if ($password == $cpassword) {
            // In 'user' in the VALUES is for user_type.
            $query = "INSERT INTO users (user_type, user_email, user_password, user_first_name, user_last_name, user_username, user_birthday, user_age, user_gender, user_weight, user_height, user_phone, user_bio, user_image) VALUES ('user', '$email', '$password', '$firstname', '$lastname', '$username', '$birthday', '$age', '$gender', '$weight', '$height', '$phonenumber', '$user_bio', '$user_image')";
            mysqli_query($mysqli, $query);
            echo "<script> alert('Registration successful'); </script>";
            // header('location: login.php');
        } else {
            echo "<script> alert('Password does not match'); </script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriAlert</title>
    <link rel="stylesheet" href="./css/css.css">
</head>
<body id="register-body">
    <div class="register-input-form">
    <h1>Register</h1>
        <form action="" method="post" autocomplete="off">
            <div class="register-form-group">
                <div class="name"></div>
                <label for="firstname">First Name</label> 
                <input type="text" id="firstname" name="firstname" required>

                <label for="lastname">Last Name</label> 
                <input type="text" id="lastname" name="lastname" required>
            </div>

            <div class="register-form-group">
                <label for="username">Username</label> 
                <input type="text" id="username" name="username" required>

                <label for="birthday">Birthday</label> 
                <input type="date" id="birthday" name="birthday" required>
            </div>

            <div class="register-form-group">
                <label for="age">Age</label> 
                <input type="number" id="age" name="age" required>

                <label for="gender">Gender</label> 
                <select id="gender" name="gender">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>

            <div class="register-form-group">
                <label for="weight">Weight (kg or lbs)</label>
                <input type="number" id="weight" name="weight" >

                <label for="height">Height (cm or inch)</label>
                <input type="number" id="height" name="height" >
            </div>

            <div class="register-form-group">
                <label for="email">Email</label> 
                <input type="email" id="email" name="email" required>

                <label for="phone">Phone Number</label> 
                <input type="number" id="phone" name="phone" required>
            </div>

            <div class="register-form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                
                <label for="cpassword">Confirm Password</label>
                <input type="password" id="cpassword" name="cpassword" required>
            </div>

            <div class="register-submit">
                <button type="submit" name="submit">Register</button>
                <button type="reset" name="reset">Reset</button>
            </div>
            <div class="register">
                <a href="login.php"><i>Already have an account?</i></a>
            </div>
        </form>
    </div>
</body>
</html>


