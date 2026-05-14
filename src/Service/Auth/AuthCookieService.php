<?php

namespace Service\Auth;

use Model\User;

class AuthCookieService implements AuthInterface
{
    protected User $userModel;
    public function __construct()
    {
        $this->userModel = new User();
    }

    public function check(): bool
    {
        return isset($_COOKIE['userId']);
    }

    public function getCurrentUser(): ?User
    {
        if ($this->check()) {
            $userId = $_COOKIE['userId'];

            return $this->userModel->getById($userId);
        } else {
            return null;
        }

    }

    public function logout(): void
    {
        setcookie('userId', '', time() - 3600, '/');
        unset($_COOKIE['userId']);
    }

    public function auth(string $email, string $password): bool
    {
        $user = $this->userModel->getByEmail($email);
        if (!$user) {
            return false;
        } else {
            $passwordDb = $user->getPassword();
            if (password_verify($password, $passwordDb)) {
                setcookie('userId', $user->getId(), time()+86400*30, '/', true, true);
                return true;
            } else {
                return false;
            }
        }
    }

}