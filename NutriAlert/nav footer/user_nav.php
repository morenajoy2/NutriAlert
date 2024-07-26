<?php 
    // session_start();
    include_once './config/db_connection.php';
?>

<nav>
    <div class="nav">
        <h2>NutriAlert</h2>
        <div class="search">
            <div class="search-container">
                <form action="search.php" method="GET">
                    <i class="bi bi-search"><input type="search" id="search-input" name="query"></i>
                    <button type="submit" id="search">Search</button>
                    <a href="filter.php"><i class="bi bi-funnel"></i></a>
                </form>
            </div>
        </div>
        <div class="nav-a">
            <a href="dashboard.php">Home</a>
            <a href="announcement.php">Announcement</a>
            <a href="profile.php">Profile</a>
            <a href="logout.php">Sign Out</a>
        </div>
    </div>
</nav>