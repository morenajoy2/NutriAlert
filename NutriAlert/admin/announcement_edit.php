<?php
    // session_start();
    include_once '../config/db_connection.php';
    $connect = mysqli_connect_mysql(); // Initialize the database connection


    $id = $_GET["id"];
    $sql = "SELECT * FROM announcements WHERE announcement_id = $id";
    $result = mysqli_query($connect, $sql);
    $row = mysqli_fetch_array($result);

    if ($row) {
        $title = $row["announcement_title"];
        $date = $row["announcement_date"];
        $description = $row["announcement_description"];
        // exit;
    } else{
        echo '<p>Announcement not found.</p>';
        exit();
    }

    if(isset($_POST['submit'])) {
        $new_title = $_POST['title'];
        $new_date = $_POST['date'];
        $new_description = $_POST['description'];

        $update_query = "UPDATE announcements 
                        SET announcement_title = '$new_title',
                                announcement_date = '$new_date',
                                announcement_description = '$new_description'
                        WHERE announcement_id = $id";
    
        if(mysqli_query($connect, $update_query)) {
            echo "<script> alert('Announcement updated successfully.'); window.location.href='./announcement_management.php'; </script>";
        } else {
            echo "<script> alert('Failed to update announcement.'); </script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriAlert</title>
    <link rel="stylesheet" href="../css/css.css">
</head>
<body>
<?php include "../nav footer/admin_nav.php"; ?>
<div class="admin-add">
    <h2>Edit Announcement</h2>
    <form action="" method="post" autocomplete="on">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>" >
        </div>

        <div class="form-group">
            <label for="date">Posted Date</label>
            <input type="date" name="date" value="<?php echo htmlspecialchars($date); ?>" >
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description"><?php echo htmlspecialchars($description); ?></textarea>
        </div>

        <div class="submit">
            <button type="submit" name="submit">Submit</button>
            <button type="reset" name="reset">Reset</button>
        </div>
    </form>
</div>
<?php include "../nav footer/admin_footer.php"; ?>

</body>
</html>
