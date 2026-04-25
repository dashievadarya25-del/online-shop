<?php

namespace Model;

use PDO;

class FeedbackProduct extends Model
{
    private int $id;
    private string $name;
    private int $product_id;
    private string $review;
    private int $created_at;
    private int $estimation;
    private float $averagegrade;

    protected static function getTableName(): string
    {
        return 'feedback_products';
    }


    public function saveFeedbackProductByAll(string $name, int $productId, string $review, int $estimation)
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("INSERT INTO $tableName (name, product_id, review, estimation, created_at) VALUES (:name, :product_id, :review, :estimation, NOW())");
        $stmt->execute([
            ':name' => $name,
            ':product_id' => $productId,
            ':review' => $review,
            ':estimation' => $estimation,
        ]);
    }

    public static function getAverageRating(int $productId) {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT AVG(estimation) as average FROM $tableName WHERE product_id = :id");
        $stmt->execute(['id' => $productId]);

        // 2. Извлекаем строку в виде ассоциативного массива
        $row = $stmt->fetch();

        // 3. Проверяем, есть ли результат, и округляем
        if ($row) {
            $result = round((float)$row['average'], 1);
        } else {
            $result = 0;
        }
        return $result;
    }

    public static function getAllByProductId(int $productId): array
    {
        $tableName = static::getTableName();
       $stmt = static::getPDO()->prepare("SELECT id, name, review, estimation, created_at 
            FROM $tableName 
            WHERE product_id = :product_id 
            ORDER BY created_at DESC");
        $stmt->execute(['product_id' => $productId]);

        return $stmt->fetchAll();
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
    public function getProductId(): int
    {
        return $this->product_id;
    }

    /**
     * @return mixed
     */
    public function getReview(): string
    {
        return $this->review;
    }

    /**
     * @return mixed
     */
    public function getEstimation(): int
    {
        return $this->estimation;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt(): int
    {
        return $this->created_at;
    }

    /**
     * @return mixed
     */
    public function getAveragegrade(): float
    {
        return $this->averagegrade;
    }
}
