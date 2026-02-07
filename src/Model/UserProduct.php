<?php

namespace Model;

class UserProduct extends Model
{
    public function getUserproductsById (int $userId)
    {
        $stmt = $this->PDO->query("SELECT * FROM user_products WHERE user_id = {$userId}");
        $userProducts = $stmt->fetchAll();
        return $userProducts;
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

    public function getAllByUserId($userId): array
    {
        $stmt = $this->PDO->prepare("SELECT * FROM user_products WHERE user_id = :userId");
        $stmt->execute([':userId' => $userId]);
        $result = $stmt->fetchAll();
        return $result;
    }
    public function deleteByUserId($userId)
    {
        $stmt = $this->PDO->prepare("DELETE FROM user_products WHERE user_id = :userId");
        $stmt->execute([':userId' => $userId]);
    }

}