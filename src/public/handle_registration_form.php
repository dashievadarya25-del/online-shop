<?php


$passwordrepeat = $_GET['psw-repeat'];

$errors = [];

if (isset($_GET['name'])) {
    $name = $_GET['name'];

    if (strlen($name) < 4) {
        $errors['name'] = 'Имя не должно быть меньше 4';
    }
} else {
    $errors['name'] = 'Имя должно быть заполнено';
}

if (isset($_GET['email'])) {
    $email = $_GET['email'];

    if (strlen($email) < 2) {
        $errors['email'] = 'email не должен быть меньше 2 символов';
    } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $errors['email'] = 'email некорректный';
    }
} else {
        $errors['email'] = 'email должен быть заполнен';
}

if (isset($_GET['psw'])) {
    $password = $_GET['psw'];

    if (strlen($password) < 4) {
        $errors['psw'] = 'Пароль не должен быть меньше 4';
    }
} else {
    $errors['psw'] = 'Пароль должен быть заполнен';
}
if (isset($_GET['psw-repeat'])) {
    $passwordrepeat = $_GET['psw-repeat'];

    if ($passwordrepeat !== $password ) {
        $errors['psw-repeat'] = 'пароли не совпадают';
    }
} else {
    $errors['psw-repeat'] = 'Подтверждение пароля обязательно';
}

if (empty($errors)) {
    $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", 'user', 'pass');

    $password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
    $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);

    $data = $stmt->fetch();
    print_r($data);
}

require_once './registration_form.php';
?>

//$statement = $pdo->query("SELECT*FROM users WHERE id > 8");
//$data = $statement->fetch();
//echo "<pre>";
//print_r($data);
//echo "</pre>";


