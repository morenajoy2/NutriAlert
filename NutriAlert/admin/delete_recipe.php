<?php 
    // session_start();
    include_once '../config/db_connection.php';
    $connect = mysqli_connect_mysql(); // Initialize the database connection

    if (isset($_GET["id"])) {
        $id = $_GET["id"];
    
        // Start transaction
        mysqli_begin_transaction($connect);
    
        try {
            // Delete related allergies data
            $sql = "DELETE FROM allergies WHERE allergy_recipe_id=$id";
            if (!mysqli_query($connect, $sql)) {
                throw new Exception("Error deleting allergies: " . mysqli_error($connect));
            }

             // Delete related considerations data
           $sql = "DELETE FROM considerations WHERE consideration_recipe_id=$id";
           if (!mysqli_query($connect, $sql)) {
               throw new Exception("Error deleting allergies: " . mysqli_error($connect));
           }

            // Delete related conditions data
            $sql = "DELETE FROM conditions WHERE condition_recipe_id=$id";
            if (!mysqli_query($connect, $sql)) {
                throw new Exception("Error deleting allergies: " . mysqli_error($connect));
            }

            // Delete related ingredients data
            $sql = "DELETE FROM ingredients WHERE ingredient_recipe_id=$id";
            if (!mysqli_query($connect, $sql)) {
                throw new Exception("Error deleting ingredients: " . mysqli_error($connect));
            }
    
            // Delete recipe data
            $sql = "DELETE FROM recipes WHERE recipe_id=$id";
            if (!mysqli_query($connect, $sql)) {
                throw new Exception("Error deleting recipe: " . mysqli_error($connect));
            }
    
            // Commit transaction
            mysqli_commit($connect);
            header("Location: ../admin/recipe_management.php");
        } catch (Exception $e) {
            // Rollback transaction
            mysqli_rollback($connect);
            echo $e->getMessage();
        }
    }
    
    mysqli_close($connect);
?>