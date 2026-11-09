<?php
require_once __DIR__ . '/../src/config/database.php';
session_start();

// logout link if user is already logged in
if (isset($_SESSION['user_id'])) {
    echo '<a href="logout.php">Logout</a>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Asset Forge Marketplace</title>

    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav>
            <a href="/asset-forge-marketplace/public/">Home</a>
            <a href="/asset-forge-marketplace/public/register.php">Register</a>
            <a href="/asset-forge-marketplace/public/login.php">Login</a>
            <a href="/asset-forge-marketplace/public/search.php">Search Assets</a>
    </nav>

    <div class="container">

        <h1>Welcome to Asset Forge Marketplace</h1>
        <p> 
            Browse and Search game development assets.
        </p>

    </div>
</body>
</html>