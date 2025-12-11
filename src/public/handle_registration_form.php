<?php

function validate(array $data): array
{
    $errors = [];

    //объявление и валидация данных
    $errorsName = validateName($data);
    if (!empty($errorsName)) {
        $errors['name'] = $errorsName;
    }



    if (isset($data['email'])) {
        $email = $data['email'];

        if (strlen($email) < 2) {
            $errors['email'] = 'email не должен быть меньше 2 символов';
        } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $errors['email'] = 'email некорректный';
        } else {
            //соединение с БД
            $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", 'user', 'pass');
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $count = $stmt->fetchColumn();
            if ($count > 0) {
                $errors['email'] = "этот email уже существует";
            }
        }
    } else {
        $errors['email'] = 'email должен быть заполнен';
    }

    if (isset($data['psw'])) {
        $password = $data ['psw'];

        if (strlen($password) < 4) {
            $errors['psw'] = 'Пароль не должен быть меньше 4';
        }

        $passwordrepeat = $data['psw-repeat'];
        if ($password !== $passwordrepeat) {
            $errors['psw-repeat'] = 'пароли не совпадают';
        }
    } else {
        $errors['psw'] = 'Пароль должен быть заполнен';
    }

    return $errors;
}

function validateName(array $data): null|string
{
    if (isset($data['name'])) {
        $name = $data['name'];

        if (strlen($name) < 2) {
            return 'Имя не должно быть меньше 2';
        }

        return null;
    } else {
         return 'Имя должно быть заполнено';
    }
}

$errors = validate($_POST);

// добавляем в БД, если нет ошибок
if (empty($errors)) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['psw'];
    $passwordrepeat = $_POST['psw-repeat'];

    $password = password_hash($password, PASSWORD_DEFAULT);
    $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", 'user', 'pass');

    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
    $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);

    $result = $stmt->fetch();
    print_r($result);
}

require_once './registration_form.php';
?>

