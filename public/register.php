<?php
require_once __DIR__ . '/../src/config/database.php';

// form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Password complexity rules
    $errors = [];

    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters.";
    }
    if (!preg_match('/[A-Z]/', $password)) {
        $errors[] = "Password must contain at least one uppercase letter.";
    }
    if (!preg_match('/[a-z]/', $password)) {
        $errors[] = "Password must contain at least one lowercase letter.";
    }
    if (!preg_match('/[0-9]/', $password)) {
        $errors[] = "Password must contain at least one number.";
    }
    if (!preg_match('/[\W]/', $password)) {
        $errors[] = "Password must contain at least one special character.";
    }

    // Shows errors if failure occurs
    if (!empty($errors)) {
        foreach ($errors as $e) {
            echo "<p style='color:red;'>$e</p>";
        }
    } else {
        // Hash the password
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Insertion of user into the database
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");

        try {
            $stmt->execute([$username, $email, $password_hash]);
            echo "<p style='color:green;'>Registration successful!</p>";
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Error: " . $e->getMessage() . "</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>

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

// Account information fields for form
    <h1>Create Account</h1>
    <form method="post" action="register.php">
        <label>Username:
            <input type="text" name="username" required>
        </label><br><br>

        <label>Email:
            <input type="email" name="email" required>
        </label><br><br>

        <label>Password:
            <input type="pasword" name="password" required>
        </label><br><br>

        <button type="submit">Register</button>

        <br><br>

        <p>
            Already have an account?
            <a href="/asset-forge-marketplace/public/login.php">
                Login here 
            </a>
        </p>      
    </form>
    </div>
</body>
</html>