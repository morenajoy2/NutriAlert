<?php 
require_once "controllerUserData.php"; 
 
   //if login now button click
   if(isset($_POST['login_now'])){
    header('Location: login.php');
}

// if($_SESSION['info'] == false){
//     header('Location: login.php');  
// }
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
<?php 
            if(isset($_SESSION['info'])){
                echo $_SESSION['info']; 
            }
            ?>
        <form action="login.php" method="post">
            <div class="login-submit">
                <button type="submit" name="login_now">Login Now</button>
            </div>
        </form>
    </div>
</body>
</html>
