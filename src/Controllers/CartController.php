<?php
namespace Controllers;

use Model\Product;
use Model\UserProduct;

class CartController
{
    private Product $productModel;
    private UserProduct $userProductModel;
    public function __construct()
    {
        $this->productModel = new Product();
        $this->userProductModel = new UserProduct();
    }
    public function getcart()
    {

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['userId'])) {
            header('Location: /login');
            exit();
        }
        $userId = $_SESSION['userId'];

        $userProducts = $this->userProductModel->getAllById($userId);

        print_r($userProducts);
        $products = [];
        foreach ($userProducts as $userProduct) {
//    $userProduct [
//        'id' => 1,
//        'user_id' => 4,
//        'product_id' => 1,
//        'amount' => 3,
//    ];
            $productId = $userProduct->getProductId();

            $product = $this->productModel->getByProductId($productId);
            //для вьюхи
            $newProducts = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'image_url' => $product->getImageUrl(),
                'description' => $product->getDescription(),
                'amount' => $userProduct->getAmount(),
            ];
           // $product['amount'] = $userProduct->getAmount();
            $products[] = $newProducts;
        }
        //print_r($products);
        require_once '../Views/cart.php';
    }

}