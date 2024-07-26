<?php
include_once './config/db_connection.php';

$connect = mysqli_connect_mysql();

// Page is set to login by default
$page = isset($_GET['page']) && file_exists($_GET['page'] . '.php') ? $_GET['page'] : 'login';

// Include and show the requested page
include $page . '.php';
?>
