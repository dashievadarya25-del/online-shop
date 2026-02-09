<?php

namespace Model;

class OrderProduct extends Model
{
    private $id;
    private $order_id;
    private $product_id;
    private $amount;

    public function create(int $orderId, int $productId, int $amount)
    {
        $stmt = $this->PDO->prepare(
            "INSERT INTO order_products (order_id, product_id, amount) VALUES (:orderId, :productId, :amount)"
        );
        $stmt->execute(['orderId' => $orderId, 'productId' => $productId, 'amount' => $amount]);
    }

    public function getAllByOrderId(int $orderId): array|null
    {
        $stmt = $this->PDO->prepare('SELECT * FROM order_products WHERE order_id = :orderId');
        $stmt->execute(['orderId' => $orderId]);
        $orderProducts = $stmt->fetchAll();

        if(!$orderProducts) {
            return null;
        }

        $newOrderProducts = [];
        foreach ($orderProducts as $orderProduct) {
            $obj = new self();
            $obj->id = $orderProduct['id'];
            $obj->order_id = $orderProduct['order_id'];
            $obj->product_id = $orderProduct['product_id'];
            $obj->amount = $orderProduct['amount'];
            $newOrderProducts[] = $obj;
        }
        return $newOrderProducts;
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


}