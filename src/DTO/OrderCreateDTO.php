<?php

namespace DTO;

use Model\User;

class OrderCreateDTO
{
    public function __construct(
        private string $contact_name,
        private string $address,
        private string $contact_phone,
        private string $comment,
        private User $user
    ){
    }

    public function getContactName(): string
    {
        return $this->contact_name;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getContactPhone(): string
    {
        return $this->contact_phone;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getUser(): User
    {
        return $this->user;
    }


}