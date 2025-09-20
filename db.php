<?php
$host = 'localhost';
$dbname = 'dbaa1ao4xcflwl';
$username = 'uannmukxu07nw';
$password = 'nhh1divf0d2c';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
