<?php
session_start(); // Start the session
include_once "../config/db_connection.php";

$connect = mysqli_connect_mysql(); // Initialize the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $title = $_POST['title'];
    $date = $_POST['date'];
    $description = $_POST['description'];
    
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Insert announcement into the database
        $stmt = $connect->prepare("
            INSERT INTO announcements (announcement_title, announcement_date, announcement_posted_by_id, announcement_description) 
            VALUES (?, ?, ?, ?)
        ");
        $stmt->bind_param("ssis", $title, $date, $user_id, $description);

        if ($stmt->execute()) {
            echo '<script>alert("New record created successfully.")</script>';
            header("Location: ../admin/announcement_management.php");
            exit(); // Make sure to stop further execution after redirect
        } else {
            echo '<script>alert("User is not logged in.")</script>';
        }

        $stmt->close();
    } else {
        echo '<script>alert(Error:' . $stmt->error .')</script>';
    }
    $connect->close();
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
<h2>New Announcement</h2>
<form action="" method="POST" autocomplete="on">
    <div class="form-group">
        <label for="title">Title</label> 
        <input type="text" id="title" name="title" required>
    </div>

    <div class="form-group">
        <label for="date">Posted Date</label> 
        <input type="date" id="date" name="date" required>
    </div>

    <div class="form-group">
        <label for="description">Description</label> 
        <textarea id="description" name="description" required></textarea>
    </div>

    <div class="submit">
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        <button type="reset" name="reset" class="btn btn-secondary">Reset</button>
    </div>
</form>
</div>
<?php include "../nav footer/admin_footer.php"; ?>
</body>
</html>