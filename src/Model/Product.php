<?php
namespace Model;

class Product extends Model
{
    private int $id;
    private string $name;
    private string $description;
    private  int $price;
    private string $image_url;


    protected function getTableName(): string
    {
        return 'products';
    }

    public function getAll(): array|null
    {
        $stmt =$this->PDO ->query("SELECT * FROM {$this->getTableName()}");
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
        $stmt = $this->PDO->prepare("SELECT * FROM {$this->getTableName()} WHERE id = :productId");
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
        $stmt = $this->PDO->query("SELECT * FROM {$this->getTableName()} WHERE id = {$productId}");
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