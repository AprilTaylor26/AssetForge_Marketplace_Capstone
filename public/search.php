<?php
require_once __DIR__ . '/../src/config/database.php';
session_start();

// Add a new asset
if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
isset($_POST['add_asset'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    $stmt=$pdo->prepare("INSERT INTO assets (title, description, file_path, category_id, created_by)
                            VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([
        $title,
        $description,
        'sample_file.zip',
        1,
        1
    ]);

    echo "<p style='color:green;'>Asset added successfully!</p>";
}

$results = [];

// search requests
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

    <div class="container">
// form for adding new assets
<form method="post">
    <label>Asset Title:</label><br>
    <input type="text" name="title" required>

    <br><br>

    <label>Description:</label><br>
    <textarea name="description" rows="4" cols="50" required></textarea>

    <br><br>

    <button type="submit" name="add_asset">
        Add Asset
    </button>
</form>

<hr>

// form for searching assets
<form method="get" action="search.php">
    <input type="text" name="q" placeholder="Search..." required>
    <button type="submit">Search</button>
</form>

<hr>

// Displays search results
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

    </div>
</body>
</html>