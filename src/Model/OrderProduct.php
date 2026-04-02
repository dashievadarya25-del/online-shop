<?php

namespace Model;

class OrderProduct extends Model
{
    private $id;
    private $order_id;
    private $product_id;
    private $amount;
    private Product $product;


    protected static function getTableName(): string
    {
        return 'order_products';
    }

    public function create(int $orderId, int $productId, int $amount)
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare(
            "INSERT INTO $tableName (order_id, product_id, amount) VALUES (:orderId, :productId, :amount)"
        );
        $stmt->execute(['orderId' => $orderId, 'productId' => $productId, 'amount' => $amount]);
    }

    public static function getAllByOrderId(int $orderId): array|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM $tableName WHERE order_id = :orderId");
        $stmt->execute(['orderId' => $orderId]);
        $orderProducts = $stmt->fetchAll();

        if(!$orderProducts) {
            return null;
        }

        $newOrderProducts = [];
        foreach ($orderProducts as $orderProduct) {
//            $obj = new self();
//            $obj->id = $orderProduct['id'];
//            $obj->order_id = $orderProduct['order_id'];
//            $obj->product_id = $orderProduct['product_id'];
//            $obj->amount = $orderProduct['amount'];
            $newOrderProducts[] = static::createObj($orderProduct);
        }
        return $newOrderProducts;
    }
    public static function getAllByOrderIdWithProducts(int $orderId): array|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare(
            "SELECT * FROM $tableName t1
                   INNER JOIN products t2 ON t1.product_id = t2.id 
                   WHERE order_id = :orderId");
        $stmt->execute(['orderId' => $orderId]);
        $orderProducts = $stmt->fetchAll();

        if(!$orderProducts) {
            return null;
        }

        $newOrderProducts = [];
        foreach ($orderProducts as $orderProduct) {
//            $obj = new self();
//            $obj->id = $orderProduct['id'];
//            $obj->order_id = $orderProduct['order_id'];
//            $obj->product_id = $orderProduct['product_id'];
//            $obj->amount = $orderProduct['amount'];
            $newOrderProducts[] = static::createObjWithProducts($orderProduct);
        }
        return $newOrderProducts;
    }

    private static function createObj(array $orderProduct): self|null
    {
        if (!$orderProduct) {
            return null;
        }
        $obj = new self();
        $obj->id = $orderProduct['id'];
        $obj->order_id = $orderProduct['order_id'];
        $obj->product_id = $orderProduct['product_id'];
        $obj->amount = $orderProduct['amount'];
        return $obj;
    }
    private static function createObjWithProducts(array $orderProduct): self|null
    {
        if (!$orderProduct) {
            return null;
        }
        $obj = static::createObj($orderProduct);
        $product = Product::createObj($orderProduct, $orderProduct['product_id']);
        $obj->setProduct($product);
        return $obj;

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
    public function getOrderId()
    {
        return $this->order_id;
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
    public function getAmount()
    {
        return $this->amount;
    }

    public function setProduct(Product $product)
    {
        $this->product = $product;
    }
    public function getProduct(): Product
    {
        return $this->product;
    }



}