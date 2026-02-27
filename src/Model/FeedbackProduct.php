<?php

namespace Model;

use PDO;

class FeedbackProduct extends Model
{
    private $id;
    private $name;
    private $product_id;
    private $review;
    private $created_at;
    private $estimation;
    private $averagegrade;


    public function saveFeedbackProductByAll(string $name, int $productId, string $review, int $estimation)
    {
        $stmt = $this->PDO->prepare("INSERT INTO feedback_products (name, product_id, review, estimation, created_at) VALUES (:name, :product_id, :review, :estimation, NOW())");
        $stmt->execute([
            ':name' => $name,
            ':product_id' => $productId,
            ':review' => $review,
            ':estimation' => $estimation,
        ]);
    }

    public function getAverageRating($productId) {
        $stmt = $this->PDO->prepare("SELECT AVG(estimation) as average FROM feedback_products WHERE product_id = :id");
        $stmt->execute(['id' => $productId]);

        // 2. Извлекаем строку в виде ассоциативного массива
        $row = $stmt->fetch();

        // 3. Проверяем, есть ли результат, и округляем
        return $row ? round((float)$row['average'], 1) : 0;
    }

    public function getAllByProductId(int $productId): array
    {
       $stmt = $this->PDO->prepare("SELECT id, name, review, estimation, created_at 
            FROM feedback_products 
            WHERE product_id = :product_id 
            ORDER BY created_at DESC");
        $stmt->execute(['product_id' => $productId]);

        return $stmt->fetchAll();
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
    public function getProductId()
    {
        return $this->product_id;
    }

    /**
     * @return mixed
     */
    public function getReview()
    {
        return $this->review;
    }

    /**
     * @return mixed
     */
    public function getEstimation()
    {
        return $this->estimation;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @return mixed
     */
    public function getAveragegrade()
    {
        return $this->averagegrade;
    }


}
