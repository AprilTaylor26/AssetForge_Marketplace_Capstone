<?php
require_once __DIR__ . '/../src/config/database.php';
session_start();

$results = [];

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['q'])) {
    $search = '%' . $_GET['q'] . '%';

    // search assets table
    $stmt = $pdo->prepare("SELECT * FROM assets WHERE title LIKE ? OR description LIKE ?");
    $stmt->execute([$search, $search]);
    $results = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search</title>

     <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <nav>
            <a href="index.php">Home</a>
            <a href="register.php">Register</a>
            <a href="login.php">Login</a>
            <a href="search.php">Search Assets</a>
    </nav>

<form method="get" action="search.php">
    <input type="text" name="q" placeholder="Search..." required>
    <button type="submit">Search</button>
</form>

<hr>

<?php if (!empty($results)): ?>
    <h2>Results:</h2>
    <?php foreach ($results as $row): ?>
       <div style="margin-bottom:20px; border:1px solid #ccc;padding:10px;">

            <strong><?php echo htmlspecialchars($row['title']);?></strong><br>
        
            <?php echo htmlspecialchars($row['description']);?>

            <br><br>

            <a href="edit.asset.php?id=<?php echo $row['id'];?>">Edit</a>

            |

            <a href="delete_asset.php?id=<?php echo $row['id'];?>"
            onclick="return confirm('Delete this asset?');">Delete</a>
        </div>
    <?php endforeach; ?>
<?php elseif (isset($_GET['q'])): ?>
    <p>No results found.</p>
<?php endif; ?>

</body>
</html>