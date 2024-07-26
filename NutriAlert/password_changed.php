<?php  
session_start(); // Ensure session is started

// Check if "Login Now" button is clicked
if (isset($_POST['login_now'])) {
    header('Location: login.php');
    exit();
}

// Check if session info is not set or is false
if (empty($_SESSION['info'])) {
    header('Location: login.php');
    exit();
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
    <?php 
    if (isset($_SESSION['info'])) {
        echo "<p>" . $_SESSION['info'] . "</p>";
        unset($_SESSION['info']); // Clear session info after displaying
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
