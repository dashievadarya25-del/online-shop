<?php
namespace Model;

class User extends Model
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;

    public function getByEmail(string $email): self|null
    {
        $stmt = $this->PDO->prepare("SELECT * FROM users WHERE email = :email");
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

    public function getUsernameByEmail(string $username): self|null
    {
        $stmt = $this->PDO->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $username]);
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

    public function getByUserId(): self|null
    {
        $stmt = $this->PDO->query('SELECT * FROM users WHERE id = ' . $_SESSION['userId']);
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