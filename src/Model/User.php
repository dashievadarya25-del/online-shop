<?php

declare(strict_types=1);

namespace Model;

class User extends Model
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;

    protected static function getTableName(): string
    {
        return 'users';
    }

    public function getByEmail(string $email): self|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM $tableName WHERE email = :email");
        $stmt->execute([':email' => $email]);

        $user = $stmt->fetch();

        if ($user === false) {
            return null;
        }

        $obj = new self();
        $obj->id = $user['id'];
        $obj->name = $user['name'];
        $obj->email = $user['email'];
        $obj->password = $user['password'];


        return $obj;
    }

    public function updateEmailById(string $email, int $userId): void
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("UPDATE $tableName SET email = :email WHERE id = :userId");
        $stmt->execute([':email' => $email, ':userId' => $userId]);
    }

    public function updateNameById(string $name, int $userId): void
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("UPDATE $tableName SET name = :name WHERE id = :userId");
        $stmt->execute([':name' => $name, ':userId' => $userId]);
    }

    public function updatePasswordById(string $password, int $userId): void
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("UPDATE $tableName SET password = :password WHERE id = :userId");
        $stmt->execute([':password' => $password, ':userId' => $userId]);
    }

    public function insertUsers(string $name, string $email, string $password): void
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("INSERT INTO $tableName (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
    }

    public function getById(int $userId): self|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM $tableName WHERE id = :userId");
        $stmt->execute([':userId' => $userId]);
        $user = $stmt->fetch();

        if ($user === false) {
            return null;
        }

        $obj = new self();
        $obj->id = $user['id'];
        $obj->name = $user['name'];
        $obj->email = $user['email'];
        $obj->password = $user['password'];

        return $obj;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

}