<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriAlert</title>
    <link rel="stylesheet" href="../css/css.css">
</head>
<body>
<?php 
    include "../nav footer/admin_nav.php";
    include_once "../config/db_connection.php"; 
    $connect = mysqli_connect_mysql(); // Initialize the database connection


    //get id (see the search "php?id=")
    $id = $_GET['id'];

    //fetch all table from announcements
    $sql = "SELECT * FROM announcements WHERE announcement_id='$id'";
    $result = mysqli_query($connect, $sql);

    if($result) {
        if(mysqli_num_rows($result) > 0) {
            while ($row_table = mysqli_fetch_assoc($result)) {              
?>

<div class="admin-box" styles="background-color:white;">
    <div class="top" >
        <h2> <?php echo $row_table["announcement_title"] ?></h2>
        <a href="./announcement_edit.php?id=<?=$row_table["announcement_id"]?>"><button type="button" id="btn_view">Edit Announcement</button></a>
    </div>
    <div class="admin_view">
        <?php
        // Retrieve the user's name from the 'users' table based on user_id
        $user_id = $row_table['announcement_posted_by_id'];
        $userQuery = "SELECT user_first_name, user_last_name FROM users WHERE user_id = $user_id";
        $userResult = $connect->query($userQuery);

        if ($userResult->num_rows == 1) {
            $userRow = $userResult->fetch_assoc();
            $postedByName = $userRow["user_first_name"] . " " . $userRow["user_last_name"];
        } else {
            $postedByName = "Unknown Name";
        }
        ?>
        <section class="content_description">
            <p><?php echo 'Posted By: ' . $postedByName ?></p>
            <p><?php echo 'Post Date: ' . date("m/d/Y", strtotime($row_table["announcement_date"])); ?></p>
            <br/>
            <p><?php echo $row_table["announcement_description"] ?></p>
        </section>
        <?php
            }
        } else {
            echo 'No announcements found';
        }
        mysqli_free_result($result);
    } else {
        echo 'Error: ' . mysqli_error($connect);
    }

    mysqli_close($connect);
?>

    </div>
</div>
<?php include '../nav footer/admin_footer.php'; ?>    <!-- FOOTER -->
</body>
</html>

