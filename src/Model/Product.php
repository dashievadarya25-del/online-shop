<?php


class Product
{
    public function getByProducts(): array|false
    {
        require_once "../Model/DB.php";
        $pdo = new DB();
        $db = $pdo->getPDO();
        $stmt = $db->query('SELECT * FROM products');
        $products = $stmt->fetchAll();
        return $products;
    }

    public function getByProductIdUserId(int $productId, int $userId)
    {
        require_once "../Model/DB.php";
        $pdo = new DB();
        $db = $pdo->getPDO();
        $stmt = $db->prepare("SELECT * FROM user_products WHERE product_id = :productId AND user_id = :userId");
        $stmt->execute(['productId' => $productId, 'userId' => $userId]);
        $data = $stmt->fetch();
        return $data;
    }

    public function insertByUserproducts($productId, $amount)
    {
        require_once "../Model/DB.php";
        $pdo = new DB();
        $db = $pdo->getPDO();
        $stmt = $db->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:userId, :productId, :amount)");
        $stmt->execute(['userId' => $_SESSION['userId'], 'productId' => $productId, 'amount' => $amount]);
    }

    public function updateByUserproducts($productId, $amount, $userId)
    {
        require_once "../Model/DB.php";
        $pdo = new DB();
        $db = $pdo->getPDO();
        $stmt = $db->prepare("UPDATE user_products SET amount = :amount WHERE user_id = :userId AND product_id = :productId");
        $stmt->execute(['amount' => $amount, 'userId' => $userId, 'productId' => $productId]);
    }

    public function getProductByProductId(int $productId)
    {
        require_once "../Model/DB.php";
        $pdo = new DB();
        $db = $pdo->getPDO();
        $stmt = $db->prepare('SELECT * FROM products WHERE id = :productId');
        $stmt->execute(['productId' => $productId]);
        $data = $stmt->fetch();
        return $data;
    }

}