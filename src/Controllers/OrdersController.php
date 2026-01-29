<?php

namespace Controllers;

use Model\User;

class OrdersController
{
    private User $userModel;
    public function __construct()
    {
        $this->userModel = new User();
    }

    public function getOrders()
    {
        require_once '../Views/order_form.php';
    }


    public function orders()
    {
        $errors = $this->regOrders($_POST);

// добавляем в БД, если нет ошибок
        if (empty($errors)) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['psw'];
            $passwordrepeat = $_POST['psw-repeat'];

            $password = password_hash($password, PASSWORD_DEFAULT);

            //require_once '../Model/User.php';

            $this->userModel->insetUsers($name, $email, $password);

            $result = $this->userModel->getByEmail($email);

            print_r($result);
        }
        require_once '../Views/order_form.php';
    }

    private function regOrders(array $data): array
    {
        $errors = [];

        //объявление и валидация данных
        if (isset($data['name'])) {
            $name = $data['name'];
            if (strlen($name) < 3) {
                $errors['name'] = "Name must be at least 3 characters";
            }
        } else {
            $errors['name'] = "Name is required";
        }

        if (isset($data['email'])) {
            $email = $data['email'];

            if (strlen($email) < 2) {
                $errors['email'] = 'email не должен быть меньше 2 символов';
            } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $errors['email'] = 'email некорректный';
            } else {
                //require_once '../Model/User.php';

                $user = $this->userModel->getByEmail($email);
                if ($user !== false) {
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

}