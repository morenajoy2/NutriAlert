<?php
    // session_start();
    include_once '../config/db_connection.php';
    $connect = mysqli_connect_mysql(); // Initialize the database connection

    if (isset($_GET["id"])) {
        $id = $_GET["id"];
    
        // Delete User data
        $sql = "DELETE FROM users WHERE user_id=$id";
    
        if (mysqli_query($connect, $sql)) {
            header("Location: ../chef/user_management.php");
    
        } else {
            echo "Error: " . mysqli_error($connect);
        }
    }
    
    mysqli_close($connect);
?>


