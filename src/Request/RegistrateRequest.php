<?php

namespace Request;

use Model\User;
use Service\AuthService;

class RegistrateRequest
{
    private User $userModel;


    public function __construct(private array $data)
    {
        $this->userModel = new User();

    }
    public function getName(): string
    {
       return $this->data['name'];
    }

    public function getEmail (): string
    {
        return $this->data['email'];
    }
    public function getPassword (): string
    {
        return $this->data['password'];
    }
    public function getPasswordRepeat(): string
    {
        return $this->data['psw-repeat'];
    }

    public function validate(): array
    {
        $errors = [];

        //объявление и валидация данных
        if (isset($this->data['name'])) {
            $name = $this->data['name'];
            if (strlen($name) < 3) {
                $errors['name'] = "Name must be at least 3 characters";
            }
        } else {
            $errors['name'] = "Name is required";
        }

        if (isset($this->data['email'])) {
            $email = $this->data['email'];

            if (strlen($email) < 2) {
                $errors['email'] = 'email не должен быть меньше 2 символов';
            } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $errors['email'] = 'email некорректный';
            } else {
                //require_once '../Model/User.php';


                $user = $this->userModel->getByEmail($email);
                if ($user === false) {
                    $errors['email'] = "этот email уже существует";
                }
            }
        } else {
            $errors['email'] = 'email должен быть заполнен';
        }

        if (isset($this->data['password'])) {
            $password = $this->data['password'];

            if (strlen($password) < 4) {
                $errors['psw'] = 'Пароль не должен быть меньше 4';
            }

            $passwordrepeat = $this->data['psw-repeat'];
            if ($password !== $passwordrepeat) {
                $errors['psw-repeat'] = 'пароли не совпадают';
            }
        } else {
            $errors['psw'] = 'Пароль должен быть заполнен';
        }

        return $errors;
    }






}