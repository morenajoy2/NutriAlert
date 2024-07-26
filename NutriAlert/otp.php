<?php 
session_start();
include_once "config/db_connection.php";
$connect = mysqli_connect_mysql(); // Initialize the database connection

$email = "";

$errors = array();

//if user click verification code submit button - otp.php
if(isset($_POST['check'])){
    $_SESSION['info'] = "";
        $otp_code = mysqli_real_escape_string($con, $_POST['otp']);
        $check_code = "SELECT * FROM users WHERE user_code = $otp_code";
        $code_res = mysqli_query($connect, $check_code);
        if(mysqli_num_rows($code_res) > 0){
            $fetch_data = mysqli_fetch_assoc($code_res);
            $fetch_code = $fetch_data['user_code'];
            $email = $fetch_data['user_email'];
            $code = 0;
            $status = 'verified';
            $update_otp = "UPDATE users SET user_code = $code, user_status = '$status' WHERE user_code = $fetch_code";
            $update_res = mysqli_query($connect, $update_otp);
            if($update_res){
                $_SESSION['email'] = $email;
                exit();
            }else{
                $errors['otp-error'] = "Failed while updating code!";
            }
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
<!-- <h1>Code Verification</h1> -->
        <form action="" method="post">
        <?php 
                    if(isset($_SESSION['info'])){
                         echo $_SESSION['info']; 
                    }
                    ?>
                    <?php
                    if(count($errors) > 0){
                            foreach($errors as $showerror){
                                echo $showerror;
                            }
                    }
                    ?>
            <div class="login-form-group">
                <label for="email">Code Verfication</label> 
                <input type="number" id="otp" name="otp" required>
            </div>
            
            <div class="login-submit">
                <button type="submit" name="check">Send</button>
            </div>
    </div>
</body>
</html>
