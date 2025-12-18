<?php

$dsn = $_ENV['DSN'];
$username = $_ENV["DB_USER"];
$password = $_ENV['DB_PASSWORD'];

try {
    $db = new PDO($dsn, $username, $password);
    $db->query('SELECT 1+1');
} catch (Exception $e) {
    echo "DB ERROR: " . $e->getMessage();
    die;
}
