<?php
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'gamescore';

$pdo = new PDO("mysql:host=$dbHost", $dbUser, $dbPass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "CREATE DATABASE IF NOT EXISTS $dbName";
$pdo->exec($sql);

$pdo->exec("USE $dbName");

$tables = ['news', 'user', 'message', 'game', 'friend', 'post', 'comment'];

foreach ($tables as $tableName) {
    $sql = "SELECT COUNT(*) 
            FROM INFORMATION_SCHEMA.TABLES 
            WHERE TABLE_SCHEMA = :dbName 
            AND TABLE_NAME = :tableName";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['dbName' => $dbName, 'tableName' => $tableName]);

    if (!$stmt->fetchColumn()) {
        $sql = file_get_contents('db_script/gamescore_create_db.sql');
        $pdo->exec($sql);
        echo "The $tableName table has been created.\n";
    }
}

header("Location: view/");
exit;