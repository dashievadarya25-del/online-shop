<?php

namespace Model;

class UserProduct extends Model
{
    public function getAllByUserId($userId): array
    {
        $stmt = $this->PDO->prepare("SELECT * FROM user_products WHERE user_id = :userId");
        $stmt->execute([':userId' => $userId]);
        $result = $stmt->fetchAll();
        return $result;
    }
    public function deleteByUserId($userId)
    {
        $stmt = $this->PDO->prepare("DELETE FROM user_products WHERE user_id = :userId");
        $stmt->execute([':userId' => $userId]);
    }

}