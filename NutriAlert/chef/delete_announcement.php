<?php
    // session_start();
    include_once '../config/db_connection.php';
    $connect = mysqli_connect_mysql(); // Initialize the database connection

    if (isset($_GET["id"])) {
        $id = $_GET["id"];
    
        // Delete announcement data
        $sql = "DELETE FROM announcements WHERE announcement_id=$id";
    
        if (mysqli_query($connect, $sql)) {
            header("Location: ../chef/announcement_management.php");
    
        } else {
            echo "Error: " . mysqli_error($connect);
        }
    }
    
    mysqli_close($connect);
?>



