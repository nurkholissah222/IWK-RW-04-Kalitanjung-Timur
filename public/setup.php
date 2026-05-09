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
    
    // Check if users exist
    $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
    $tableExists = $stmt->rowCount() > 0;
    
    $userCount = 0;
    if ($tableExists) {
        $userCount = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    }
    
    if ($userCount == 0) {
        // Import SQL
        $sql = file_get_contents('c:/xampp/htdocs/db_iwk_rw04.sql');
        if ($sql) {
            $pdo->exec($sql);
            echo "SQL Imported. ";
        } else {
            echo "Failed to read SQL file. ";
        }
    } else {
        echo "Database already has $userCount users. ";
    }
    
    // Reset passwords
    require __DIR__.'/../vendor/autoload.php';
    $app = require_once __DIR__.'/../bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    $kernel->handle(Illuminate\Http\Request::capture());
    
    \App\Models\User::query()->update(['password' => \Illuminate\Support\Facades\Hash::make('password123')]);
    
    echo "Passwords updated successfully! You can login now.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
