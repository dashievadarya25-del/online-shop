<?php

session_start();

if (isset($_SESSION['userId'])) {

    $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');

    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :userId");
    $stmt->bindParam(':userId', $_SESSION['userId'], PDO::PARAM_INT);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        require_once './edit_profile_form.php';
    }
}

if (isset($_SESSION['userId'])) {
    $errors = [];
    function validate(array $data): array
    {
        $errors = [];

        if (!isset($data['first-name'])) {
            $errors['first-name'] = 'Поле Username обязательно для заполнения';
        }

        if (!isset($data['address'])) {
            $errors['address'] = 'Поле Email обязательно для заполнения';
        }

        if (!isset($data['password'])) {
            $errors['password'] = 'Поле Password обязательно для заполнения';
        }
        return $errors;
    }

    $errors = validate($_POST);

    if (empty($errors)) {
        $username = $_POST["first-name"];
        $email = $_POST["address"];
        $password = $_POST["password"];

        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :userId");
        $stmt->bindParam(':userId', $_SESSION['userId'], PDO::PARAM_INT);
        $stmt->execute(); // Выполнение запроса

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!empty($user)) {
            $passwordDb = $user['password'];
            if (password_verify($password, $passwordDb)) {
                require_once './edit_profile_form.php';
            } else {
                echo "Пользователь не найден.";
            }
        }
    }
}