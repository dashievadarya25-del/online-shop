<?php

class Products
{
    public function getCatalog()
    {
        require_once './pages/catalog_form.php';
    }
    public function catalog()
    {
        session_start();

        if (isset($_SESSION['userId'])) {
            $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", 'user', 'pass');

            $stmt = $pdo->query('SELECT * FROM products');
            $products = $stmt->fetchAll();

            require_once './pages/catalog_form.php';
        } else {
            header("Location: /login");
        }
    }

    public function getaddProducts()
    {
       require_once './pages/add_product_form.php';
    }
    public function addProduct()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['userId'])) {
            header('Location: /login');
            exit;
        }


        $errors = $this->addproductValidate($_POST);
        print_r($errors);

        if (empty($errors)) {
            $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", 'user', 'pass');
            $userId = $_SESSION['userId'];
            $productId = $_POST['product_id'];
            $amount = $_POST['amount'];

            $stmt = $pdo->prepare("SELECT * FROM user_products WHERE product_id = :productId AND user_id = :userId");
            $stmt->execute(['productId' => $productId, 'userId' => $userId]);
            $data = $stmt->fetch();

            if ($data === false) {
                $stmt = $pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:userId, :productId, :amount)");
                $stmt->execute(['userId' => $_SESSION['userId'], 'productId' => $productId, 'amount' => $amount]);
            } else {
                $amount = $data['amount'] + $amount;

                $stmt = $pdo->prepare("UPDATE user_products SET amount = :amount WHERE user_id = :userId AND product_id = :productId");
                $stmt->execute(['amount' => $amount, 'userId' => $userId, 'productId' => $productId]);
            }

        }
    }
    function addproductValidate(array $data): array
    {
        $errors = [];

        if (isset($data['product_id'])) {
            $productId = (int) $data['product_id'];

//  id == productId
            $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", 'user', 'pass');
            $stmt = $pdo->prepare('SELECT * FROM products WHERE id = :productId');
            $stmt->execute(['productId' => $productId]);
            $data = $stmt->fetch();

            if ($data === false) {
                $errors['product_id'] = 'Product id does not exist';
            }
        } else {
            $errors['product_id'] = 'Product id is required';
        }
        // определяем ограничение на количество
//    if (isset($data['amount'])) {
//        $data['amount'] >= 0;
//    } else {
//        $errors['amount'] = 'Amount is required';


//    }

        return $errors;

    }
}