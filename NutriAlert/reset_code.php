<?php 
session_start();
include_once "config/db_connection.php";
$connect = mysqli_connect_mysql(); // Initialize the database connection

$email = "";

$errors = array();

//if user click check reset otp button
if(isset($_POST['reset_otp'])){
    $_SESSION['info'] = "";
    $otp_code = mysqli_real_escape_string($connect, $_POST['otp']);
    $check_code = "SELECT * FROM users WHERE user_code = $otp_code";
    $code_res = mysqli_query($connect, $check_code);
    if(mysqli_num_rows($code_res) > 0){
        $fetch_data = mysqli_fetch_assoc($code_res);
        $email = $fetch_data['user_email'];
        $_SESSION['user_email'] = $email;
        $info = "Please create a new password that you don't use on any other site.";
        $_SESSION['info'] = $info;
        header('location: new_password.php');
        exit();
    }else{
        $errors['otp-error'] = "You've entered incorrect code!";
    }
}


$email = $_SESSION['user_email'];
if($email == false){
  header('Location: login.php');
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
        <form action="reset_code.php" method="post" autocomplete="off">
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
                <label for="otp">Code Verification</label>
                <input type="number" id="otp" name="otp" required>
            </div>
            <div class="login-submit">
                <button type="submit" name="reset_otp">Send</button>
            </div>
        </form>
    </div>
</body>
</html>
