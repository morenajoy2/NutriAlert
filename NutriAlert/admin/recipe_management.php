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
        <h2>Recipe Management</h2>
        <a href="./recipe_add.php"><button type="button" class="btn_add btn btn-primary">Add Recipe</button></a>
        <div class="search">
            <div class="search-container-box">
                <!-- <form action="recipe_management.php" method="GET"> -->
                <form>
                    <i class="bi bi-search"><input type="search" id="search-input" name="query"></i>
                    <button type="submit" id="search" class="btn btn-secondary">Search</button>
                </form>
            </div>
        </div>
    </div>
        <?php
        // Fetch users for the dropdown
        $query = "SELECT `user_id`, `user_first_name`, `user_last_name` FROM `users`";
        $result = mysqli_query($connect, $query);
        
        $options = '';
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $options .= "<option value='{$row['user_id']}'>{$row['user_first_name']} "." {$row['user_last_name']}</option>";
            }
            mysqli_free_result($result);
        } else {
            echo "Error: " . mysqli_error($connect);
        }
    ?>
    <div class="table-responsive">
        <table id="table" class="table table-striped table-bordered">
            <tr>
                <th></th>
                <th style="text-align: center;">NAME</th>
                <th style="text-align: center;">TIME</th>
                <th style="text-align: center;">POSTED BY </th>
                <th style="text-align: center;">IMAGE</th>
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
                $stmt = $connect->prepare("SELECT * FROM recipes WHERE recipe_name LIKE ? LIMIT ?, ?");
                $stmt->bind_param("sii", $like_query, $start_from, $num_per_page);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $count = $start_from + 1;
                    while ($row = $result->fetch_assoc()) { 
                         // Retrieve the user's name from the 'users' table based on user_id
                        $user_id = $row['recipe_posted_by_id'];
                        $userQuery = "SELECT user_first_name, user_last_name FROM users WHERE user_id = $user_id";
                        $userResult = $connect->query($userQuery);

                        if ($userResult->num_rows == 1) {
                            $userRow = $userResult->fetch_assoc();
                            $postedByName = "Chef " . $userRow["user_first_name"] . " " . $userRow["user_last_name"];
                        } else {
                            $postedByName = "Unknown Chef";
                        }
                        ?>
                    
                        <tr>
                            <td><?=$count?></td>
                            <td><?=$row['recipe_name']; ?></td>
                            <td><?=$row['recipe_time'] . " minutes"; ?></td>
                            <td><?=$postedByName; ?></td>
                            <td><img src='../images/<?=$row["recipe_image"]?>' alt='<?=$row["recipe_name"]?>' style="max-width: 100px; max-height: 100px;"></td>
                            <td><a href="./recipe_detail.php?id=<?=$row['recipe_id']; ?>"><button type="button" id="btn-action">View</button></a></td>
                            <td><button id="btn-action" onclick="confirmDelete('<?=$row['recipe_id']?>')">Delete</button></td>
                        </tr>
                    <?php $count++; } 
                } else { ?>
                    <tr>
                        <td colspan="6">No recipes found</td>
                    </tr>
                <?php } ?>
        </table>
    </div>
    <div class="pagination">
        <!-- Pagination links -->
        <?php
        $pr_query = "SELECT * FROM recipes WHERE recipe_name LIKE '%$query%'";
        $pr_result = mysqli_query($connect, $pr_query);
        $total_recipes = mysqli_num_rows($pr_result);
        $total_page = ceil($total_recipes / $num_per_page);

        if ($page > 1) {
            echo "<a href='./recipe_management.php?page=" . ($page - 1) . "' class='btn_page'>Previous</a>";
        }

        for ($i = 1; $i <= $total_page; $i++) {
            echo "<a href='./recipe_management.php?page=" . $i . "' class='btn_page'>$i</a>";
        }

        if ($page < $total_page) {
            echo "<a href='./recipe_management.php?page=" . ($page + 1) . "' class='btn_page'>Next</a>";
        }
        ?>
    </div>
</div>
<?php include '../nav footer/admin_footer.php'; ?>    <!-- FOOTER -->
</body>
<script>
    function confirmDelete(recipeId) {
    if (confirm("Are you sure you want to delete this recipe?")) {
        window.location.href = './delete_recipe.php?id=' + recipeId;
    }
}
</script>
</html>