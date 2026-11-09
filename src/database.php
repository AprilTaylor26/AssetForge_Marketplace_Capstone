<?php
// Database information (server, name, username, password, encoding)
$host = 'localhost';
$db = 'asset_forge_db';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

// Connection
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Connection settings like errors and returing data and statements
$options = [
    PDO::ATTR_ERRMODE              => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE   => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES     => false,
];

// Connection and catch if fails
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e-getMessage());
}