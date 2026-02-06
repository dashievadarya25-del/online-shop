<?php

namespace Model;

use PDO;

class Order extends Model
{
    public function create(string $contact_name, string $address, int $contact_phone, string $comment, int $userId)
    {
        $stmt = $this->PDO->prepare(
            "INSERT INTO orders (contact_name, address, contact_phone, comment, user_id)
                   VALUES (:contact_name, :address, :contact_phone,  :comment, :user_id) RETURNING id"
        );
        $stmt->execute([
            'contact_name' =>$contact_name,
            'address' =>$address,
            'contact_phone' =>$contact_phone,
            'comment' => $comment,
            'user_id' =>$userId
        ]);

        $data = $stmt->fetch();

        return $data['id'];
    }

    public function getAllByUserId($userId): array
    {
        $stmt = $this->PDO->prepare('SELECT * FROM orders WHERE user_id = :userId');
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetchAll();
    }

}