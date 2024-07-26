<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriAlert</title>
    <link rel="stylesheet" href="../css/css.css">
</head>
<?php 
    session_start();
    include "../nav footer/chef_nav.php";
    include_once "../config/db_connection.php";
    $connect = mysqli_connect_mysql(); // Initialize the database connection

    // Fetch recipes for the dropdown
    $query = "SELECT `recipe_id`, `recipe_name` FROM `recipes`";
    $result = mysqli_query($connect, $query);
    
    $options = '';
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $options .= "<option value='{$row['recipe_id']}'>{$row['recipe_name']}</option>";
        }
        mysqli_free_result($result);
    } else {
        echo "Error: " . mysqli_error($connect);
    }

    // Handle the search query
    $search_query = isset($_GET['query']) ? $_GET['query'] : '';
    $like_query = "%$search_query%";

    // Pagination
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
    $num_per_page = 5;  // Number of rows per page
    $start_from = ($page - 1) * $num_per_page;

    // Prepare and execute the query for ingredients and recipes
    $stmt = $connect->prepare("
        SELECT i.*, r.recipe_name 
        FROM ingredients i 
        JOIN recipes r ON i.ingredient_recipe_id = r.recipe_id 
        WHERE i.ingredient_name LIKE ? OR r.recipe_name LIKE ? 
        LIMIT ?, ?
    ");
    $stmt->bind_param("ssii", $like_query, $like_query, $start_from, $num_per_page);
    $stmt->execute();
    $result = $stmt->get_result();
?>

<div class="admin-box-box">
    <div class="top">
        <h2>Ingredient Management</h2>
        <a href="./ingredient_add.php"><button type="button" class="btn_add btn btn-primary">Add Ingredient</button></a>
        <div class="search">
            <div class="search-container-box">
                <form>
                    <i class="bi bi-search">
                        <input type="search" id="search-input" name="query" value="<?= htmlspecialchars($search_query) ?>">
                    </i>
                    <button type="submit" id="search" class="btn btn-secondary">Search</button>
                </form>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table id="table" class="table table-striped table-bordered">
            <tr>
                <th></th>
                <th style="text-align: center;">RECIPE NAME</th>
                <th style="text-align: center;">NAME</th>
                <th style="text-align: center;">QUANTITY</th>
                <th style="text-align: center;">UNIT</th>
                <th colspan="2" style="text-align: center;">ACTION</th>
            </tr>
            <?php 
                if ($result->num_rows > 0) {
                    $count = $start_from + 1;
                    while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?=$count?></td>
                            <td><?=$row['recipe_name']; ?></td>
                            <td><?=$row['ingredient_name']; ?></td>
                            <td><?=$row['ingredient_quantity']; ?></td>
                            <td><?=$row['ingredient_unit']; ?></td>
                            <td><a href="./ingredient_edit.php?id=<?=$row['ingredient_id']?>"><button type="button" id="btn-action">Edit</button></a></td>
                            <td><button id="btn-action" onclick="confirmDelete(<?=$row['ingredient_id']?>)">Delete</button></td>
                        </tr>
                    <?php $count++; } 
                } else { ?>
                    <tr>
                        <td colspan="7">No recipes or ingredients found</td>
                    </tr>
                <?php } ?>
        </table>
    </div>
    <div class="pagination">
        <?php
        // Get the total number of rows for pagination
        $pr_query = "
            SELECT COUNT(*) as total 
            FROM ingredients i 
            JOIN recipes r ON i.ingredient_recipe_id = r.recipe_id 
            WHERE i.ingredient_name LIKE ? OR r.recipe_name LIKE ?
        ";
        $pr_stmt = $connect->prepare($pr_query);
        $pr_stmt->bind_param("ss", $like_query, $like_query);
        $pr_stmt->execute();
        $pr_result = $pr_stmt->get_result();
        $row = $pr_result->fetch_assoc();
        $total_ingredients = $row['total'];
        $total_page = ceil($total_ingredients / $num_per_page);

        // Pagination buttons
        if ($page > 1) {
            echo "<a href='./ingredient_management.php?page=" . ($page - 1) . "&query=" . urlencode($search_query) . "' class='btn_page'>Previous</a>";
        }

        for ($i = 1; $i <= $total_page; $i++) {
            echo "<a href='./ingredient_management.php?page=" . $i . "&query=" . urlencode($search_query) . "' class='btn_page'>$i</a>";
        }

        if ($page < $total_page) {
            echo "<a href='./ingredient_management.php?page=" . ($page + 1) . "&query=" . urlencode($search_query) . "' class='btn_page'>Next</a>";
        }
        ?>
    </div>
</div>
<?php include '../nav footer/chef_footer.php'; ?>    <!-- FOOTER -->
</body>
<script>
    function confirmDelete(ingredientId) {
    if (confirm("Are you sure you want to delete this ingredient?")) {
        window.location.href = './delete_ingredient.php?id=' + ingredientId;
    }
}
</script>
</html>
