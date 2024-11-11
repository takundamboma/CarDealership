<?php
$host = 'localhost'; // Your database host
$db = 'Car_Dealership'; // Your database name
$user = 'root'; // Your database username
$pass = 'takufata@73M'; // Your database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
