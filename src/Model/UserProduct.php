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
    protected static function getTableName(): string
    {
        return "user_products";
    }
    public static function getAllUserProductsByUserId (int $userId): array|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->query("SELECT * FROM $tableName WHERE user_id = {$userId}");
        $userProducts = $stmt->fetchAll();

//        if(!$userProducts) {
//            return null;
//        }

        $products = [];
        foreach ($userProducts as $userProduct) {
            $products[] = static::createObj($userProduct);
        }
        return $products;

    }
    public function getByProductIdUserId(int $productId, int $userId): self|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM $tableName WHERE product_id = :productId AND user_Id = :userId");
        $stmt->execute(['productId' => $productId, 'userId' => $userId]);
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
        $stmt = static::getPDO()->prepare(
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
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare(
            "UPDATE $tableName SET amount = :amount WHERE user_id = :userId AND product_id = :productId"
        );
        $stmt->execute([
            'amount' => $amount,
            'userId' => $userId,
            'productId' => $productId
        ]);
    }

    public static function getAllByUserIdWithProducts (int $userId): array|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->query(
            "SELECT * FROM $tableName up 
                   INNER JOIN products p ON up.product_id = p.id 
                   WHERE user_id = $userId");
        $userProducts = $stmt->fetchAll();

        $products = [];
        foreach ($userProducts as $userProduct) {
            $products[] = static::createObjWithProducts($userProduct);
        }
        return $products;

    }


    public static function getAllByUserId($userId): array|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM $tableName WHERE user_id = :userId");
        $stmt->execute([':userId' => $userId]);
        $userProducts = $stmt->fetchAll();

        $products = [];
        foreach ($userProducts as $userProduct) {
           $products[] = static::createObj($userProduct);
        }
        return $products;
    }
    public function deleteByUserId($userId)
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("DELETE FROM $tableName WHERE user_id = :userId");
        $stmt->execute([':userId' => $userId]);
    }

    public function deleteByUserproducts($productId, $userId)
    {
        $tableName = static::getTableName();
        $stmt =  static::getPDO()->prepare("DELETE FROM $tableName WHERE product_id = :product_id AND user_id = :user_id");
        $stmt->execute([
            'product_id' => $productId,
            'user_id'    => $userId
        ]);

    }
    private static function createObj(array $userProduct): self|null
    {
        if (!$userProduct) {
            return null;
        }

        $obj = new self;
        $obj->id = $userProduct['id'];
        $obj->user_id = $userProduct['user_id'];
        $obj->product_id = $userProduct['product_id'];
        $obj->amount = $userProduct['amount'];
        return $obj;
    }

    private static function createObjWithProducts(array $userProduct): self|null
    {
        if(!$userProduct)
        {
            return null;
        }
//
//        $obj = new self;
//        $obj->id = $userProduct['id'];
//        $obj->user_id = $userProduct['user_id'];
//        $obj->product_id = $userProduct['product_id'];
//        $obj->amount = $userProduct['amount'];
         $obj = static::createObj($userProduct);

//        $productData = [
//            'id' =>$userProduct['id'],
//            'name' =>$userProduct['name'],
//            'description' =>$userProduct['description'],
//            'price' =>$userProduct['price'],
//            'image_url' =>$userProduct['image_url'],
//        ];

        $product = Product::createObj($userProduct, $userProduct['product_id']);
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