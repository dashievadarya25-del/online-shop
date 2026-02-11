<?php
namespace Model;

class Product extends Model
{
    private $id;
    private $name;
    private $description;
    private $price;
    private $image_url;

    public function getAll(): array|null
    {
        $stmt =$this->PDO ->query('SELECT * FROM products');
        $productsData = $stmt->fetchAll();

        if ($productsData === false) {
            return null;
        }
        $result = [];
        foreach ($productsData as $product) {
            $obj = new self();
            $obj->id = $product['id'];
            $obj->name = $product['name'];
            $obj->description = $product['description'];
            $obj->price = $product['price'];
            $obj->image_url = $product['image_url'];

            $result[] = $obj;
        }
        return $result;

    }

    public function getByProductId(int $productId): self|null
    {
        $stmt = $this->PDO->prepare('SELECT * FROM products WHERE id = :productId');
        $stmt->execute(['productId' => $productId]);
        $product = $stmt->fetch();

        if(!$product) {
            return null;
        }

        $obj = new self();
        $obj->id = $product['id'];
        $obj->name = $product['name'];
        $obj->description = $product['description'];
        $obj->price = $product['price'];
        $obj->image_url = $product['image_url'];

        return $obj;
    }

       public function getOneById(int $productId): self|null
    {
        $stmt = $this->PDO->query("SELECT * FROM products WHERE id = {$productId}");
        $product = $stmt->fetch();

        if(!$product) {
            return null;
        }

        $obj = new self();
        $obj->id = $product['id'];
        $obj->name = $product['name'];
        $obj->description = $product['description'];
        $obj->price = $product['price'];
        $obj->image_url = $product['image_url'];

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return mixed
     */
    public function getImageUrl()
    {
        return $this->image_url;
    }


}