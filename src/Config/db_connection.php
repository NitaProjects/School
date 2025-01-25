<?php
$dsn = 'mysql:host=localhost;dbname=dani';
$username = 'dani';
$password = 'dani';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];
$pdo = new PDO($dsn, $username, $password, $options);
?>
