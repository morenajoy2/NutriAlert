<?php 
session_start();
include_once "config/db_connection.php";
$connect = mysqli_connect_mysql(); // Initialize the database connection

$email = "";
$errors = array();

// If user clicks the change password button
if (isset($_POST['change_password'])) {
    $_SESSION['info'] = "";
    $password = mysqli_real_escape_string($connect, $_POST['password']);
    $cpassword = mysqli_real_escape_string($connect, $_POST['cpassword']);

    if ($password !== $cpassword) {
        $errors['password'] = "Confirm password not matched!";
    } else {
        $email = $_SESSION['user_email']; // Getting this email using session

        if (empty($email)) {
            header('Location: login.php');
            exit();
        }

        $code = 0;
        
        // Update query with plaintext password
        $update_pass = "UPDATE users SET user_code = $code, user_password = '$password' WHERE user_email = '$email'";
        $run_query = mysqli_query($connect, $update_pass);

        if ($run_query) {
            $_SESSION['info'] = "Your password has been changed. Now you can login with your new password.";
            header('Location: password_changed.php');
            exit();
        } else {
            $errors['db-error'] = "Failed to change your password!";
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
<body id="login-body">
<div class="login-input-form">
    <h1>New Password</h1>
    <form action="new_password.php" method="POST" autocomplete="off">
        <?php 
        if (isset($_SESSION['info'])) {
            echo $_SESSION['info'];
        }
        ?>
        <?php
        if (count($errors) > 0) {
            foreach ($errors as $showerror) {
                echo $showerror;
            }
        }
        ?>
        <div class="login-form-group">
            <label for="password">New Password</label> 
            <input type="password" id="password" name="password" required>
        </div>
        <div class="login-form-group">
            <label for="cpassword">Confirm New Password</label> 
            <input type="password" id="cpassword" name="cpassword" required>
        </div>
        <div class="login-submit">
            <button type="submit" name="change_password">Change</button>
        </div>
    </form>
</div>
</body>
</html>
