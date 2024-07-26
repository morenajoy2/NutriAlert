<?php
session_start();
include_once '../config/db_connection.php';
include '../nav footer/admin_nav.php'; // NAVIGATION

$connect = mysqli_connect_mysql(); // Initialize the database connection

$id = $_GET['id'];
$sql = "SELECT * FROM users WHERE user_id = ?";
$stmt = mysqli_prepare($connect, $sql);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_array($result);

if ($row) {
    // Assign user data to variables
    $first_name = $row['user_first_name'];
    $last_name = $row['user_last_name'];
    $username = $row['user_username'];
    $email = $row['user_email'];
    $phone = $row['user_phone']; 
    $weight = $row['user_weight'];
    $height = $row['user_height'];
    $bio = $row['user_bio']; 
    $image = $row['user_image'];
} else {
    echo '<p class="error-message">User not found.</p>';
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriAlert</title>
    <link rel="stylesheet" href="../css/css.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
.profile-bio {
    margin-top: 20px;
    font-size: 14px; /* Adjust font size */
    max-width: 600px; /* Set max-width to align with image */
}
    </style>
</head>
<body>
    <div class="profile-box">
        <div class="profile-img">
            <img src='../images/<?=$image?>' alt='<?=$first_name?>' style="max-width: 400px; max-height: 400px;">
        </div>
        <div class="profile-info">
            <h3>Personal Information</h3>
            <div class="profile-name">
                <div class="profile-name-name">
                    <b>First Name</b>
                    <?php echo $first_name; ?>
                </div>
                <div class="profile-name-name">
                    <b>Last Name</b>
                    <?php echo $last_name; ?>
                </div>
            </div>
            <div class="profile-email-phone">
                <div class="profile-email-phone-email-phone">
                    <b>Email Address</b>
                    <?php echo $email; ?>
                </div>
                <div class="profile-email-phone-email-phone">
                    <b>Phone Number</b>
                    <?php echo $phone; ?>
                </div>
            </div>
            <div class="profile-weight-height">
                <div class="profile-weight-height-weight-height">
                    <b>Weight</b>
                    <?php echo $weight; ?> kg
                </div>
                <div class="profile-weight-height-weight-height">
                    <b>Height</b>
                    <?php echo $height; ?> inch
                </div>
                <div class="profile-weight-height-weight-height">
                    <b>Username</b>
                    <?php echo $username; ?>
                </div>
            </div>
            <div class="profile-bio">
                <b>Bio</b>
                <?php echo $bio; ?>
            </div>
            <div class="profile-edit">
                <a href="./profile_edit.php?id=<?= $id; ?>">
                    <button>Edit Information</button>
                </a>
            </div>
        </div>
    </div>
</body>
<?php include '../nav footer/admin_footer.php'; ?>    <!-- FOOTER -->
</html>
