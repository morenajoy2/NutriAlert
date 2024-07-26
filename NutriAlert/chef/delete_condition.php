<?php
    // session_start();
    include_once '../config/db_connection.php';
    $connect = mysqli_connect_mysql(); // Initialize the database connection

    if (isset($_GET["id"])) {
        $id = $_GET["id"];
    
        // Delete condition data
        $sql = "DELETE FROM conditions WHERE condition_id=$id";
    
        if (mysqli_query($connect, $sql)) {
            header("Location: ../chef/condition_management.php");
    
        } else {
            echo "Error: " . mysqli_error($connect);
        }
    }
    
    mysqli_close($connect);
?>



