<?php

declare(strict_types=1);

namespace Request;

use Model\User;
use Service\Auth\AuthSessionService;

class EditProfileRequest
{
    private User $userModel;
    private AuthSessionService $authService;

    public function __construct(private array $data)
    {
        $this->userModel = new User();
        $this->authService = new AuthSessionService();

    }

    public function getName(): string
    {
        return $this->data['name'];
    }

    public function getPassword(): string
    {
        return $this->data['password'];
    }

    public function getEmail(): string
    {
        return $this->data['email'];
    }

    public function editProfileValidate(): array
    {
        $errors = [];

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
                $currentUser = $this->authService->getCurrentUser();

                $userWithRequestedEmail = $this->userModel->getByEmail($email);

                if ($userWithRequestedEmail && $userWithRequestedEmail->getId() !== $currentUser->getId()) {
                    $errors['email'] = "Этот email уже занят другим пользователем";
                }
            }
        }

        if (isset($this->data['password'])) {
            $password = $this->data['password'];

            if (strlen($password) < 4) {
                $errors['password'] = 'Пароль не должен быть меньше 4';
            }

        }
        return $errors;
    }

}