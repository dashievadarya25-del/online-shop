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

    public function getProductByProductId(int $productId)
    {
        $stmt = $this->PDO->prepare('SELECT * FROM products WHERE id = :productId');
        $stmt->execute(['productId' => $productId]);
        $data = $stmt->fetch();
        return $data;
    }

       public function getOneById(int $productId): array|false
    {
        $stmt = $this->PDO->query("SELECT * FROM products WHERE id = {$productId}");
        $product = $stmt->fetch();
        return $product;
    }

}