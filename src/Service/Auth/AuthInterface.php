<?php

namespace Service\Auth;

use Model\User;

interface AuthInterface
{

    public function check(): bool;

    public function getCurrentUser(): ?User;

    public function logout(): void;

    public function auth(string $email, string $password): bool;

}