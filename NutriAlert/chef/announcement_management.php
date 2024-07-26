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
    session_start(); // Start the session
    include "../nav footer/chef_nav.php";
    include_once "../config/db_connection.php";
    $connect = mysqli_connect_mysql(); // Initialize the database connection

?> 
<div class="admin-box-box">
    <div class="top">
        <h2>Announcement Management</h2>
        <a href="./announcement_add.php"><button type="button" class="btn_add btn btn-primary">Add Announcement</button></a>
        <div class="search">
            <div class="search-container-box">
                <form>
                    <i class="bi bi-search"><input type="search" id="search-input" name="query"></i>
                    <button type="submit" id="search" class="btn btn-secondary">Search</button>
                </form>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table id="table" class="table table-striped table-bordered">
            <tr>
                <th></th>
                <th style="text-align: center;">TITLE</th>
                <th style="text-align: center;">POSTED DATE</th>
                <th colspan="2" style="text-align: center;">ACTION</th>
            </tr>
            <?php 
                // Pagination
                $page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
                $num_per_page = 5;  // Number of rows per page
                $start_from = ($page - 1) * $num_per_page;
                
                // Search functionality
                $query = isset($_GET['query']) ? $_GET['query'] : '';
                $like_query = "%$query%";
                $stmt = $connect->prepare("SELECT * FROM announcements WHERE announcement_title LIKE ? LIMIT ?, ?");
                $stmt->bind_param("sii", $like_query, $start_from, $num_per_page);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $count = $start_from + 1;
                    while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?=$count?></td>
                            <td><?=$row['announcement_title']; ?></td>
                            <td><?=date("m/d/Y", strtotime($row['announcement_date']));?></td>
                            <td><a href="./announcement_details.php?id=<?= $row['announcement_id'];?>"> <button type="button" id="btn-action">View Details</button></a></td>
                            <td><button id="btn-action" onclick="confirmDelete('<?=$row['announcement_id']?>')">Delete</button></td>
                        </tr>
                    <?php $count++; } 
                } else { ?>
                    <tr>
                        <td colspan="4">No announcements found</td>
                    </tr>
                <?php } ?>
        </table>
    </div>
    <div class="pagination">
        <!-- Pagination links -->
        <?php
        $pr_query = "SELECT * FROM announcements WHERE announcement_title LIKE '%$query%'";
        $pr_result = mysqli_query($connect, $pr_query);
        $total_announcements = mysqli_num_rows($pr_result);
        $total_page = ceil($total_announcements / $num_per_page);

        if ($page > 1) {
            echo "<a href='./announcement_management.php?page=" . ($page - 1) . "' class='btn_page'>Previous</a>";
        }

        for ($i = 1; $i <= $total_page; $i++) {
            echo "<a href='./announcement_management.php?page=" . $i . "' class='btn_page'>$i</a>";
        }

        if ($page < $total_page) {
            echo "<a href='./announcement_management.php?page=" . ($page + 1) . "' class='btn_page'>Next</a>";
        }
        ?>
    </div>
</div>


<?php include '../nav footer/chef_footer.php'; ?>    <!-- FOOTER -->
</body>
<script>
    function confirmDelete(announcementId) {
    if (confirm("Are you sure you want to delete this announcement?")) {
        window.location.href = './delete_announcement.php?id=' + announcementId;
    }
}
</script>
</html>