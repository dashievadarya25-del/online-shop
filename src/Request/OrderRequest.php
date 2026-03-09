<?php

namespace Request;

class OrderRequest
{
    public function __construct(private array $data)
    {

    }

    public function getContactName(): string
    {
        return $this->data['contact_name'];
    }

    public function getAddress(): string
    {
        return $this->data['address'];
    }
    public function getContactPhone(): string
    {
        return $this->data['contact_phone'];
    }

    public function getComment(): string
    {
        return $this->data['comment'];
    }

    public function regOrders(): array
    {
        $errors = [];

        //объявление и валидация данных
        if (isset($this->data['contact_name'])) {
            $contact_name = $this->data['contact_name'];
            if (strlen($contact_name) < 2) {
                $errors['contact_name'] = "Name must be at least 2 characters";
            }
        } else {
            $errors['contact_name'] = "Name is required";
        }

        if (isset($this->data['address'])) {
            $address = $this->data['address'];

            if (strlen($address) < 5) {
                $errors['address'] = 'address не должен быть меньше 5 символов';
            }
        }

        if (isset($this->data['contact_phone'])) {
            $contact_phone = $this->data ['contact_phone'];

            if (strlen($contact_phone) < 11) {
                $errors['phone'] = 'должно содержать не меньше 11 символов';
            }
        }
        return $errors;
    }


}