<?php
namespace Model;

class Product extends Model
{
    private int $id;
    private string $name;
    private string $description;
    private  int $price;
    private string $image_url;


    protected static function getTableName(): string
    {
        return 'products';
    }

    public static function getAll(): array|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->query("SELECT * FROM $tableName");
        $productsData = $stmt->fetchAll();

//        if ($productsData === false) {
//            return null;
//        }
        $result = [];
        foreach ($productsData as $product) {
//            $obj = new self();
//            $obj->id = $product['id'];
//            $obj->name = $product['name'];
//            $obj->description = $product['description'];
//            $obj->price = $product['price'];
//            $obj->image_url = $product['image_url'];

            $result[] = static::createObj($product);
        }
        return $result;

    }

    public static function getByProductId(int $productId): self|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM $tableName WHERE id = :productId");
        $stmt->execute(['productId' => $productId]);
        $product = $stmt->fetch();

//        if(!$product) {
//            return null;
//        }
//
//        $obj = new self();
//        $obj->id = $product['id'];
//        $obj->name = $product['name'];
//        $obj->description = $product['description'];
//        $obj->price = $product['price'];
//        $obj->image_url = $product['image_url'];
//
//        return $obj;
        return static::createObj($product);
    }

       public static function getOneById(int $productId): self|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->query("SELECT * FROM $tableName WHERE id = {$productId}");
        $product = $stmt->fetch();

//        if(!$product) {
//            return null;
//        }
//
//        $obj = new self();
//        $obj->id = $product['id'];
//        $obj->name = $product['name'];
//        $obj->description = $product['description'];
//        $obj->price = $product['price'];
//        $obj->image_url = $product['image_url'];
//
//        return $obj;
           return static::createObj($product);
    }

    public static function createObj(array $product, int $id = null):self|null
    {
        if(!$product) {
            return null;
        }

        $obj = new self();
        if ($id !== null) {
            $obj->id = $id;//передаем аргумент
        } else {
            $obj->id = $product['id'];
        }
        $obj->name = $product['name'];
        $obj->description = $product['description'];
        $obj->price = $product['price'];
        $obj->image_url = $product['image_url'];

        return $obj;

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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @return mixed
     */
    public function getImageUrl(): string
    {
        return $this->image_url;
    }



}