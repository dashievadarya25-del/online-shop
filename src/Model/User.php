<?php


class User
{
    private PDO $PDO;

    public function __construct()
    {
        $this->PDO = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", 'user', 'pass');
    }
    public function getByEmail(string $email): array|false
    {
        $stmt = $this->PDO->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);

        $result = $stmt->fetch();

        return $result;
    }

    public function updateEmailById(string $email, int $userId)
    {
        $stmt = $this->PDO->prepare("UPDATE users SET email = :email WHERE id = $userId");
        $stmt->execute([':email' => $email]);
    }

    public function updateNameById(string $name, int $userId)
    {
        $stmt = $this->PDO->prepare("UPDATE users SET name = :name WHERE id = $userId");
        $stmt->execute([':name' => $name]);
    }

    public function getById(string $userId)
    {
        $stmt = $this->PDO->query("SELECT * FROM users WHERE id = '$userId'");
        $result = $stmt->fetch();

        return $result;
    }

    public function insetUsers(string $name, string $email, string $password)
    {
        $stmt = $this->PDO->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
    }

    public function getUsernameByEmail(string $username)
    {
        $stmt = $this->PDO->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $username]);
        $user = $stmt->fetch();
        return $user;
    }

    public function getByUserId()
    {
        $stmt = $this->PDO->query('SELECT * FROM users WHERE id = ' . $_SESSION['userId']);
        $user = $stmt->fetch();
        return $user;
    }
}