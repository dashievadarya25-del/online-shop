<?php

namespace Model;

class UserProduct extends Model
{
    private int $id;
    private int $user_id;
    private int $product_id;
    private int $amount;
    private Product $product;
    private int $totalSum;
    protected function getTableName(): string
    {
        return "user_products";
    }
    public function getAllUserProductsByUserId (int $userId): array|null
    {
        $stmt = $this->PDO->query("SELECT * FROM {$this->getTableName()} WHERE user_id = {$userId}");
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
    public function getByProductIdUserId(int $productId, int $userId): self|null
    {
        $stmt = $this->PDO->prepare("SELECT * FROM {$this->getTableName()} WHERE product_id = :productId AND user_id = :userId");
        $stmt->execute(['productId' => $productId, 'userId' => $_SESSION['userId']]);
        $userProduct = $stmt->fetch();
        if(!$userProduct) {
            return null;
        }

            $obj = new self;
            $obj->id = $userProduct['id'];
            $obj->user_id = $userProduct['user_id'];
            $obj->product_id = $userProduct['product_id'];
            $obj->amount = $userProduct['amount'];


        return $obj;

    }

    public function insertByUserproducts(int $userId, int $productId, int $amount)
    {
        $stmt = $this->PDO->prepare(
            "INSERT INTO user_products (user_id, product_id, amount) VALUES (:userId, :productId, :amount)"
        );
        $stmt->execute([
            'userId' => $userId,
            'productId' => $productId,
            'amount' => $amount
        ]);
    }

    public function updateByUserproducts(int $productId, int $amount, int $userId)
    {
        $stmt = $this->PDO->prepare(
            "UPDATE {$this->getTableName()} SET amount = :amount WHERE user_id = :userId AND product_id = :productId"
        );
        $stmt->execute([
            'amount' => $amount,
            'userId' => $userId,
            'productId' => $productId
        ]);
    }


    public function getAllByUserId($userId): array|null
    {
        $stmt = $this->PDO->prepare("SELECT * FROM {$this->getTableName()} WHERE user_id = :userId");
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
        $stmt = $this->PDO->prepare("DELETE FROM {$this->getTableName()} WHERE user_id = :userId");
        $stmt->execute([':userId' => $userId]);
    }

    public function deleteByUserproducts($productId, $userId)
    {
        $stmt =  $this->PDO->prepare("DELETE FROM {$this->getTableName()} WHERE product_id = :product_id AND user_id = :user_id");
        $stmt->execute([
            'product_id' => $productId,
            'user_id'    => $userId
        ]);

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
    public function setProduct(Product $product)
    {
        $this->product = $product;
    }
    public function getProduct(): Product
    {
        return $this->product;
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