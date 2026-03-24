<?php

namespace Model;

use PDO;

class Order extends Model
{
    private $id;
    private $contact_name;
    private $contact_phone;
    private $comment;
    private $user_id;
    private $address;

    protected static function getTableName(): string
    {
        return 'orders';
    }

    public function create(string $contact_name, string $address, int $contact_phone, string $comment, int $userId)
    {
        $stmt = static::getPDO()->prepare(
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

    public static function getAllByUserId($userId): array|null
    {
        $stmt = static::getPDO()->prepare('SELECT * FROM orders WHERE user_id = :userId');
        $stmt->execute(['userId' => $userId]);
        $userOrders = $stmt->fetchAll();

        if (!$userOrders) {
            return null;
        }

        $newUserOrders = [];
        foreach ($userOrders as $userOrder) {
            $obj = new self();
            $obj->id = $userOrder['id'];
            $obj->contact_name = $userOrder['contact_name'];
            $obj->contact_phone = $userOrder['contact_phone'];
            $obj->comment = $userOrder['comment'];
            $obj->user_id = $userOrder['user_id'];

            $newUserOrders[] = $obj;
        }
        return $newUserOrders;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getContactName()
    {
        return $this->contact_name;
    }

    /**
     * @return mixed
     */
    public function getContactPhone()
    {
        return $this->contact_phone;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }


}

