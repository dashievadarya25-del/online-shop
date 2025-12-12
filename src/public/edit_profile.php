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
        $firstName = $_POST['first-name'];
        $address = $_POST['address']; // Вы используете 'email' в базе данных, но 'address' в HTML
        $password = $_POST['password'];

        // Начало SQL-запроса
        $sql = "UPDATE users SET name = :firstName, email = :address, password = :password WHERE id = :userId";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':firstName' => $firstName, ':address' => $address, ':password' => $password,
            ':userId' => $_SESSION['userId']]);

    }

}
