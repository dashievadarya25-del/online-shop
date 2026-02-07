<?php
namespace Controllers;
use Model\Product;
use Model\UserProduct;


class ProductController
{
    private Product $productModel;

    private UserProduct $userProductModel;
    public function __construct()
    {
        $this->productModel = new Product();
        $this->userProductModel = new UserProduct();
    }
    public function getCatalog()
    {
        session_start();

        if (isset($_SESSION['userId'])) {

            $products = $this->productModel->getByProducts();

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
        //print_r($errors);

        if (empty($errors)) {
            $userId = $_SESSION['userId'];
            $productId = $_POST['product_id'];
            $amount = $_POST['amount'];

            $data = $this->userProductModel->getByProductIdUserId($productId, $userId);

            if ($data === false) {


                $this->userProductModel->insertByUserproducts($productId, $amount);
            } else {
                $amount = $data['amount'] + $amount;

                $this->userProductModel->updateByUserproducts($productId, $amount, $userId);

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


            $data = $this->productModel->getProductByProductId($productId);

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