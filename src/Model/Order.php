<?php

namespace Model;

use PDO;

class Order extends Model
{
    private int $id;
    private string $contact_name;
    private string $contact_phone;
    private string $comment;
    private int $user_id;
    private string $address;
    private int $totalSum;

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
            $obj->address = $userOrder['address'];

            $newUserOrders[] = $obj;
        }
        return $newUserOrders;
    }

    /**
     * @return mixed
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getContactName(): string
    {
        return $this->contact_name;
    }

    /**
     * @return mixed
     */
    public function getContactPhone(): string
    {
        return $this->contact_phone;
    }

    /**
     * @return mixed
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @return mixed
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @return mixed
     */
    public function getAddress(): string
    {
        return $this->address;
    }
    public function setTotalSum(int $totalSum): void
    {
        $this->totalSum = $totalSum;
    }
    public function getTotalSum(): int
    {
        return $this->totalSum;
    }

}

