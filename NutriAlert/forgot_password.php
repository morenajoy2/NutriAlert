<?php 
session_start();
include_once "config/db_connection.php";
$connect = mysqli_connect_mysql(); // Initialize the database connection

$email = "";

$errors = array();

//if user click continue button in forgot password form
if(isset($_POST['send_email'])){
    $email = mysqli_real_escape_string($connect, $_POST['email']);
        $check_email = "SELECT * FROM users WHERE user_email='$email'";
        $run_sql = mysqli_query($connect, $check_email);
        if(mysqli_num_rows($run_sql) > 0){
            $code = rand(999999, 111111);
            $insert_code = "UPDATE users SET user_code = $code WHERE user_email = '$email'";
            $run_query =  mysqli_query($connect, $insert_code);
            if($run_query){
                $subject = "Password Reset Code";
                $message = "Your password reset code is $code";
                $sender = "From: hernandeznicolejoy2002@gmail.com";
                if(mail($email, $subject, $message, $sender)){
                    $info = "We've sent a password reset otp to your email - $email";
                    $_SESSION['info'] = $info;
                    $_SESSION['user_email'] = $email;
                    header('location: reset_code.php');
                    exit();
                }else{
                    $errors['otp-error'] = "Failed while sending code!";
                }
            }else{
                $errors['db-error'] = "Something went wrong!";
            }
        }else{
            $errors['email'] = "This email address does not exist!";
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
<h1>Forgot Password</h1>
        <form action="forgot_password.php" method="POST" autocomplete="">
            <div class="login-form-group">
            <?php
                        if(count($errors) > 0){
                            foreach($errors as $error){
                                echo $error;
                            }
                        }
                    ?>
                <label for="email">Email</label> 
                <input type="text" id="email" name="email" value="<?php echo $email ?>"required>
            </div>
            
            <div class="login-submit">
                <button type="submit" name="send_email">Send</button>
            </div>
            <div class="login-register">
                <a href="login.php"><i>Back to login</i></a>
            </div>
        </form>
    </div>
</body>
</html>
