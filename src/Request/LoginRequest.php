<?php

namespace Request;


class LoginRequest
{
    public function __construct(private array $data)
    {

    }

    public function getEmail (): string
    {
        return $this->data['email'];
    }
    public function getPassword (): string
    {
        return $this->data['password'];
    }

    public function logValidate(): array
    {
        $errors = [];

        if (!isset($this->data['email'])) {
            $errors['email'] = 'Поле Email обязательно для заполнения';
        }
        if (!isset($this->data['password'])) {
            $errors['password'] = 'Поле Password обязательно для заполнения';
        }
        return $errors;
    }



}