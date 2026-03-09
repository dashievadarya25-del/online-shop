<?php

namespace Request;

use Model\User;

class EditprofileRequest
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
    public function getPassword (): string
    {
        return $this->data['password'];
    }


    public function getEmail (): string
    {
        return $this->data['email'];
    }


    public function editProfilevalidate(): array
    {
        $errors = [];

        //объявление и валидация данных
        if (isset($this->data['name'])) {
            $name = $this->data['name'];
            if (strlen($name) < 3) {
                $errors['name'] = "Name must be at least 3 characters";
            }
        }

        if (isset($this->data['email'])) {
            $email = $this->data['email'];

            if (strlen($email) < 2) {
                $errors['email'] = 'email не должен быть меньше 2 символов';
            } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $errors['email'] = 'email некорректный';
            } else {

                $user = $this->userModel->getByEmail($email);

                $userId = $_SESSION['userId'];
                if ($user->getId() !== $userId) {
                    $errors['email'] = "этот email уже существует";
                }
            }
        }

        if (isset($this->data['password'])) {
            $password = $this->data ['password'];

            if (strlen($password) < 4) {
                $errors['password'] = 'Пароль не должен быть меньше 4';
            }

        }
        return $errors;
    }

}