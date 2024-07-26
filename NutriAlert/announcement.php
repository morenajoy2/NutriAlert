<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriAlert</title>
    <link rel="stylesheet" href="./css/css.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<?php
    session_start();
    include_once './config/db_connection.php';
    include './nav footer/user_nav.php'; //NAVIGATION

    $connect = mysqli_connect_mysql(); // Initialize the database connection
?> 
<div class="announcement-box">
        <h2>Announcements</h2>
            <table>
                <?php
                
                // SQL query to retrieve all announcement titles
                $sql = "SELECT announcement_id, announcement_title FROM announcements";
                
                $result = $connect->query($sql);
                
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["announcement_title"] . "</td>";
                        echo "<td><a href='announcement_details.php?id=" . $row["announcement_id"] . "'><button id='view-btn'>View</button></a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No announcements found</td></tr>";
                }
                ?>
            </table>
    </div>
    <?php include './nav footer/user_footer.php'; ?>    <!-- FOOTER -->
</body>
</html>
