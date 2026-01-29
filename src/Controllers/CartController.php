<?php
namespace Controllers;

use Model\Product;

class CartController
{
    private Product $productModel;
    public function __construct()
    {
        $this->productModel = new Product();
    }
    public function getcart()
    {
        //require_once "../Model/Model.php";
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['userId'])) {
            header('Location: /login');
            exit();
        }
        $userId = $_SESSION['userId'];

        $userProducts = $this->productModel->getUserproductsById($userId);

        print_r($userProducts);
        $products = [];
        foreach ($userProducts as $userProduct) {
//    $userProduct [
//        'id' => 1,
//        'user_id' => 4,
//        'product_id' => 1,
//        'amount' => 3,
//    ];
            $productId = $userProduct['product_id'];

            $product = $this->productModel->getProductByProductId($productId);
            $product['amount'] = $userProduct['amount'];
            $products[] = $product;
        }
        //print_r($products);
        require_once '../Views/cart.php';
    }

}