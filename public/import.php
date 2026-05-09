<?php
$host = '127.0.0.1';
$db   = 'db_iwk_rw04';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db`");
    $pdo->exec("USE `$db`");
    
    $sql = file_get_contents('c:/xampp/htdocs/db_iwk_rw04.sql');
    if ($sql === false) {
        die("Error reading SQL file");
    }
    
    // Execute the SQL file content
    $pdo->exec($sql);
    echo "Database imported successfully!";
} catch (\PDOException $e) {
    echo "Database Error: " . $e->getMessage();
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
@unlink(__FILE__);
