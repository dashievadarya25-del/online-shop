<?php

session_start();

if (isset($_SESSION['userId'])) {
    $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", 'user', 'pass');

    $stmt = $pdo->query('SELECT * FROM products');
    $products = $stmt->fetchAll();

    require_once './catalog_form.php';
} else {
    header("Location: /login_form.php");
}



?>


