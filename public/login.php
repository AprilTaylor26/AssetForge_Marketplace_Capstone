<?php
require_once __DIR__ . '/../src/config/database.php';
session_start(); // starts the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Looks up the user
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user) {
        // Verifies the password
        if (password_verify($password, $user['password_hash'])) {
            // Stores user information in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            echo "<p style=color:green;'>Login successful!</p>";

            // Redirects to home or dashboard
            //header("Location: index.php");
            //exit;

        } else {
            echo "<p style='color:red;'>Incorrect password.</p>";
        }
    } else {
        echo "<p style='color:red;'>User not found.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

     <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <  <nav>
            <a href="index.php">Home</a>
            <a href="register.php">Register</a>
            <a href="login.php">Login</a>
            <a href="search.php">Search Assets</a>
    </nav>

    <h1>Login</h1>
    <form method="post" action="login.php">
        <label>Username:
            <input type="text" name="username" required>
        </label><br><br>

        <label>Password:
            <input type="password" name="password" required>
        </label><br><br>

        <button type="submit">Login</button>
    </form>
</body>
</html>