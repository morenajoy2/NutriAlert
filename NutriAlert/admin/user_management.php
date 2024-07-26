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
    session_start();
    include "../nav footer/admin_nav.php";
    include_once "../config/db_connection.php";

    $connect = mysqli_connect_mysql(); // Initialize the database connection
?> 
<div class="admin-box-box">
    <div class="top">
        <h2>User Management</h2>
        <a href="./user_add.php"><button type="button" class="btn_add btn btn-primary">Add User</button></a>
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
                <th style="text-align: center;">TYPE</th>
                <th style="text-align: center;">EMAIL</th>
                <th style="text-align: center;">PASSWORD</th>
                <th style="text-align: center;">USERNAME</th>
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
                $stmt = $connect->prepare("SELECT * FROM users WHERE user_email LIKE ? OR user_username LIKE ? OR user_type LIKE ? LIMIT ?, ?");
                $stmt->bind_param("sssii", $like_query, $like_query, $like_query, $start_from, $num_per_page);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $count = $start_from + 1;
                    while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?=$count?></td>
                            <td><?=$row['user_type']; ?></td>
                            <td><?=$row['user_email']; ?></td>
                            <td><?=$row['user_password']; ?></td>
                            <td><?=$row['user_username']; ?></td>
                            <td><a href="./profile.php?id=<?=$row['user_id']; ?>"><button type="button" id="btn-action">View</button></a></td>
                            <td><button id="btn-action" onclick="confirmDelete('<?=$row['user_id']?>')">Delete</button></td>
                        </tr>
                    <?php $count++; } 
                } else { ?>
                    <tr>
                        <td colspan="7">No Users found</td>
                    </tr>
                <?php } ?>
        </table>
    </div>
    <div class="pagination">
        <!-- Pagination links -->
        <?php
        $pr_query = "SELECT * FROM users WHERE user_email LIKE ? OR user_username LIKE ? OR user_type LIKE ?";
        $pr_stmt = $connect->prepare($pr_query);
        $pr_stmt->bind_param("sss", $like_query, $like_query, $like_query);
        $pr_stmt->execute();
        $pr_result = $pr_stmt->get_result();
        $total_users = $pr_result->num_rows;
        $total_page = ceil($total_users / $num_per_page);

        if ($page > 1) {
            echo "<a href='./user_management.php?page=" . ($page - 1) . "' class='btn_page'>Previous</a>";
        }

        for ($i = 1; $i <= $total_page; $i++) {
            echo "<a href='./user_management.php?page=" . $i . "' class='btn_page'>$i</a>";
        }

        if ($page < $total_page) {
            echo "<a href='./user_management.php?page=" . ($page + 1) . "' class='btn_page'>Next</a>";
        }
        ?>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script>
    function confirmDelete(userId) {
        if (confirm("Are you sure you want to delete this user?")) {
            window.location.href = './delete_user.php?id=' + userId;
        }
    }
</script>

<?php include '../nav footer/admin_footer.php'; ?>    <!-- FOOTER -->

</body>
</html>
