<?php
$errors = [];
function validate(array $data): array
{
    $errors = [];

    if (!isset($data['u'])) {
        $errors['u'] = 'Поле Username обязательно для заполнения';
    }
    if (!isset($data['p'])) {
        $errors['p'] = 'Поле Password обязательно для заполнения';
    }
    return $errors;
}

$errors = validate($_POST);
if (empty($errors)) {
    $username = $_POST["u"];
    $password = $_POST["p"];

    $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", 'user', 'pass');
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $username]);

    $user = $stmt->fetch();
    if (!empty($user)) {
        $passwordDb = $user['password'];

        if (password_verify($password, $passwordDb)) {
            //вход через сессии
            session_start();
            $_SESSION['userId'] = $user['id'];
            //вход через куки
            // setcookie('user_id', $user['id']);
            header("Location: /catalog.php");
        } else {
            $errors['u'] = 'username or password incorrect';
        }
    } else {
        $errors['u'] = 'пользователя с таким логином не существует';
    }
}

require_once './login_form.php';