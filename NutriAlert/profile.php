<?php 
    session_start(); // Start the session
    include 'nav footer/user_nav.php'; // NAVIGATION
    include_once 'config/db_connection.php'; // Database connection

    $connect = mysqli_connect_mysql(); // Initialize the database connection

    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM users WHERE user_id = $user_id";
    $result = mysqli_query($connect, $sql);
    $row = mysqli_fetch_array($result);

    if ($row) {
        $id = $row['user_id'];
        $first_name = $row['user_first_name'];
        $last_name = $row['user_last_name'];
        $username = $row['user_username'];
        $email = $row['user_email'];
        $phone = $row['user_phone']; 
        $weight = $row['user_weight'];
        $height = $row['user_height'];
        $bio = $row['user_bio']; 
        $image = $row['user_image']; // Assuming the column for the image is `user_image`

    } else {
        echo "<script> alert('User not found.'); </script>";
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
        <img src='./images/<?=$image?>' alt='<?=$first_name?>' style="max-width: 400px; max-height: 400px;">
        </div>
        <div class="profile-info">
            <h3>Personal Information</h3>
            <div class="profile-name">
                <div class="profile-name-name">
                    <b>First Name</b>
                    <?= $first_name ?>
                </div>

                <div class="profile-name-name">
                    <b>Last Name</b>
                    <?= $last_name ?>
                </div>
            </div>

            <div class="profile-email-phone">
                <div class="profile-email-phone-email-phone">
                    <b>Email Address</b>
                    <?= $email ?>
                </div>

                <div class="profile-email-phone-email-phone">
                    <b>Phone Number</b>
                    <?= $phone ?>
                </div>
            </div>

            <div class="profile-weight-height">
                <div class="profile-weight-height-weight-height">
                    <b>Weight</b>
                    <?= $weight ?> kg
                </div>

                <div class="profile-weight-height-weight-height">
                    <b>Height</b>
                    <?= $height ?> inch
                </div>

                <div class="profile-weight-height-weight-height">
                    <b>Username</b>
                    <?= $username?>
                </div>
            </div>

            <div class="profile-bio">
                <b>Bio</b>
                <?= $bio?>
            </div>
            <div class="profile-edit">
                <a href="profile_edit.php?id=<?= $id ?>">
                    <button>Edit Information</button>
                </a>
            </div>
        </div>
    </div>
    <?php include './nav footer/user_footer.php'; ?>    <!-- FOOTER -->
</body>
</html>
