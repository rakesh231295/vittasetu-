<?php
// $host = 'localhost';
// $dbname = 'u652866976_vittasetu';
// $dbUsername = 'u652866976_vittasetu';
// $dbPassword = '1OSB|F|HJv^Q';

$host = 'localhost';
$dbname = 'finance';
$dbUsername = 'root';
$dbPassword = '';

try {
    $pdo = new PDO(
        "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
        $dbUsername,
        $dbPassword,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    die('Database connection failed.');
}
