<?php
require_once __DIR__ . '/../src/config/database.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM assets WHERE id = ?");
$stmt->execute([$id]);

$asset = $stmt->fetch();

if (!$asset) {
    die("Asset not found.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $title = $_POST['title'];
    $description = $_POST['description'];

    $update = $pdo->prepare(
        "UPDATE assets
        SET title = ?, description = ?
        WHERE id = ?"
    );

    $update->execute([
        $title,
        $description,
        $id
    ]);

    header("Location: search.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Asset</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<h1>Edit Asset</h1>

<form method="post">
    <labal>Title:</label><br>
    <input
        type="text"
        name="title"
        value="<?php echo htmlspecialchars($asset['title']); ?>"
        required
    >

    <br><br>

    <label>Description:</label><br>

    <textarea
        name="description"
        rows="4"
        cols="50"
        required
    ><?php echo htmlspecialchars($asset['description']);?>
    </textarea>

    <br><br>

    <button type="submit">Save Changes</button>
</form>
</body>
</html>
