<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    session_start();
    include_once './config/db_connection.php';

    $connect = mysqli_connect_mysql();

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Ensure you are using prepared statements to avoid SQL injection attacks
        $sql = "SELECT * FROM users WHERE user_email = ? AND user_password = ?";
        $stmt = mysqli_prepare($connect, $sql);

        if (!$stmt) {
            echo "<script> alert(Statement preparation failed: " . mysqli_error($connect).  "); </script>";
            exit();
        }

        mysqli_stmt_bind_param($stmt, 'ss', $email, $password);

        if (!mysqli_stmt_execute($stmt)) {
            echo "<script> alert(Execution failed: " . mysqli_error($connect).  "); </script>";
        }

        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_array($result);

        if ($row) {
            $_SESSION['user_type'] = $row["user_type"];
            $_SESSION['user_id'] = $row["user_id"];
            
            if ($row["user_type"] === 'admin') {
                $_SESSION['user_firstname'] = $row["user_first_name"];
                $_SESSION['user_lastname'] = $row["user_last_name"];
                header("Location: ./admin/dashboard.php");
                exit();
            } elseif ($row["user_type"] === 'user') {
                header("Location: dashboard.php");
                exit();
            } elseif ($row["user_type"] === 'chef') {
                $_SESSION['user_firstname'] = $row["user_first_name"];
                $_SESSION['user_lastname'] = $row["user_last_name"];
                header("Location: ./chef/dashboard.php");
                exit();
            }
        } else {
            // Display error message only when login fails
            echo "<script>alert('EMAIL OR PASSWORD INCORRECT');</script>";
        }

        // Close statement and connection
        mysqli_stmt_close($stmt);
        mysqli_close($connect);
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
        <h1>Login</h1>
        <form action="" method="post">    
            <div class="login-form-group">
                <label for="email">Email</label> 
                <input type="text" id="email" name="email" required>
            </div>
            <div class="login-form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="login-forgot">
                <a href="forgot_password.php"><i>Forgot Password?</i></a>
            </div>
            <div class="login-submit">
                <button type="submit" name="submit">Login</button>
            </div>
            <div class="login-register">
                <a href="register.php"><i>Don't have an account?</i></a>
            </div>
        </form>
    </div>
</body>
</html>

