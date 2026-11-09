<?php
require_once __DIR__ . '/../src/config/database.php';

// Makes sure an ID was given
if (!isset($_GET['id'])) {
    die("No asset ID provided.");
}

$id = $_GET['id'];

// Deletes any inventory records first
$stmt = $pdo->prepare("DELETE FROM inventory WHERE asset_id = ?");
$stmt->execute([$id]);

// Delte any purchase records first
$stmt = $pdo->prepare("DELETE FROM purchases WHERE asset_id = ?");
$stmt->execute([$id]);

// Delete the asset itself
$stmt = $pdo->prepare("DELETE FROM assets WHERE id = ?");
$stmt->execute($id);

// Return to search page
header("Location: search.php");
exit;
?>