<?php

$username = $_POST["u"];
$password = $_POST["p"];

$pdo = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", 'user', 'pass');
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
$stmt->execute(['email' => $username]);

$user = $stmt->fetch();
$errors = [];

if ($user === false) {
    $errors['u'] = "username or password is incorrect";
} else {
    $passwordDb = $user['password'];

    if (password_verify($password, $passwordDb)) {
        setcookie('user_id', $user['id']);
       header("Location: /catalog.php");
    } else {
        $errors['u'] = 'username or password incorrect';
    }
}

require_once './login_form.php';