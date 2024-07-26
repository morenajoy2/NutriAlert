<?php
function mysqli_connect_mysql() {
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'NutriAlert';

    $connect = new mysqli($host, $username, $password, $dbname);

    // Check connection
    if ($connect->connect_error) {
        die("Connection failed: " . $connect->connect_error);
    }

    return $connect;
}
?>
