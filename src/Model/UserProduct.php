<?php

namespace Model;

class UserProduct extends Model
{
    private $id;
    private $user_id;
    private $product_id;
    private $amount;
    public function getAllById (int $userId): array|null
    {
        $stmt = $this->PDO->query("SELECT * FROM user_products WHERE user_id = {$userId}");
        $userProducts = $stmt->fetchAll();

        if(!$userProducts) {
            return null;
        }

        $products = [];
        foreach ($userProducts as $userProduct) {
            $obj = new self;
            $obj->id = $userProduct['id'];
            $obj->user_id = $userProduct['user_id'];
            $obj->product_id = $userProduct['product_id'];
            $obj->amount = $userProduct['amount'];
            $products[] = $obj;
        }
        return $products;

    }
    public function getByProductIdUserId(int $productId, int $userId): array|false
    {
        $stmt = $this->PDO->prepare("SELECT * FROM user_products WHERE product_id = :productId AND user_id = :userId");
        $stmt->execute(['productId' => $productId, 'userId' => $userId]);
        $data = $stmt->fetch();
        return $data;
    }

    public function insertByUserproducts(int $productId, int $amount)
    {
        $stmt = $this->PDO->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:userId, :productId, :amount)");
        $stmt->execute(['userId' => $_SESSION['userId'], 'productId' => $productId, 'amount' => $amount]);
    }

    public function updateByUserproducts(int $productId, int $amount, int $userId)
    {
        $stmt = $this->PDO->prepare("UPDATE user_products SET amount = :amount WHERE user_id = :userId AND product_id = :productId");
        $stmt->execute(['amount' => $amount, 'userId' => $userId, 'productId' => $productId]);
    }

    public function getAllByUserId($userId): array|null
    {
        $stmt = $this->PDO->prepare("SELECT * FROM user_products WHERE user_id = :userId");
        $stmt->execute([':userId' => $userId]);
        $userProducts = $stmt->fetchAll();

        if(!$userProducts) {
            return null;
        }

        $products = [];
        foreach ($userProducts as $userProduct) {
            $obj = new self;
            $obj->id = $userProduct['id'];
            $obj->user_id = $userProduct['user_id'];
            $obj->product_id = $userProduct['product_id'];
            $obj->amount = $userProduct['amount'];
            $products[] = $obj;
        }
        return $products;
    }
    public function deleteByUserId($userId)
    {
        $stmt = $this->PDO->prepare("DELETE FROM user_products WHERE user_id = :userId");
        $stmt->execute([':userId' => $userId]);
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
    public function getProductId()
    {
        return $this->product_id;
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
    public function getAmount()
    {
        return $this->amount;
    }


}