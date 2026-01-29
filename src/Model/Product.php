<?php
namespace Model;

class Product extends Model
{

    public function getByProducts(): array|false
    {
        $stmt =$this->PDO ->query('SELECT * FROM products');
        $products = $stmt->fetchAll();
        return $products;
    }

    public function getByProductIdUserId(int $productId, int $userId): array|false
    {
        $stmt = $this->PDO->prepare("SELECT * FROM user_products WHERE product_id = :productId AND user_id = :userId");
        $stmt->execute(['productId' => $productId, 'userId' => $userId]);
        $data = $stmt->fetch();
        return $data;
    }

    public function insertByUserproducts($productId, $amount)
    {
        $stmt = $this->PDO->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:userId, :productId, :amount)");
        $stmt->execute(['userId' => $_SESSION['userId'], 'productId' => $productId, 'amount' => $amount]);
    }

    public function updateByUserproducts($productId, $amount, $userId)
    {
        $stmt = $this->PDO->prepare("UPDATE user_products SET amount = :amount WHERE user_id = :userId AND product_id = :productId");
        $stmt->execute(['amount' => $amount, 'userId' => $userId, 'productId' => $productId]);
    }

    public function getProductByProductId(int $productId)
    {
        $stmt = $this->PDO->prepare('SELECT * FROM products WHERE id = :productId');
        $stmt->execute(['productId' => $productId]);
        $data = $stmt->fetch();
        return $data;
    }

    public function getUserproductsById (int $userId)
    {
        $stmt = $this->PDO->query("SELECT * FROM user_products WHERE user_id = {$userId}");
        $userProducts = $stmt->fetchAll();
        return $userProducts;
    }

}