<?php

class ProductController
{
    public function getCatalog()
    {
        require_once '../Views/catalog_form.php';
    }

    public function catalog()
    {
        session_start();

        if (isset($_SESSION['userId'])) {
            require_once '../Model/Product.php';
            $productModel = new Product();

            $products = $productModel->getByProducts();

            require_once '../Views/catalog_form.php';
        } else {
            header("Location: /login");
        }
    }

    public function getaddProducts()
    {
        require_once '../Views/add_product_form.php';
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

            require_once '../Model/Product.php';
            $productModel = new Product();
            $data = $productModel->getByProductIdUserId($productId, $userId);

            if ($data === false) {
                require_once '../Model/Product.php';
                $productModel = new Product();
                $productModel->insertByUserproducts($productId, $amount);
            } else {
                $amount = $data['amount'] + $amount;
                require_once '../Model/Product.php';
                $productModel = new Product();
                $productModel->updateByUserproducts($productId, $amount, $userId);

            }
            header('Location: /catalog');
        }
    }

    function addproductValidate(array $data): array
    {
        $errors = [];

        if (isset($data['product_id'])) {
            $productId = (int)$data['product_id'];

//  id == productId
            require_once '../Model/Product.php';
            $productModel = new Product();
            $data = $productModel->getProductByProductId($productId);

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