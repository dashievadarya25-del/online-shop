<?php
namespace Controllers;

use Model\Product;
use Model\UserProduct;
use Service\AuthService;

class CartController extends BaseController
{
    private Product $productModel;
    private UserProduct $userProductModel;
    public function __construct()
    {
        parent::__construct();
        $this->productModel = new Product();
        $this->userProductModel = new UserProduct();
    }
    public function getcart()
    {
        if ($this->authService->check()) {
            $user = $this->authService->getCurrentUser();

            $userProducts = $this->userProductModel->getAllUserProductsByUserId($user->getId());

            $products = [];

            if (!empty($userProducts) && is_iterable($userProducts))
            {
                foreach ($userProducts as $userProduct) {

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
                    $products[] = $newProducts;

                }
            }



            //print_r($products);
            require_once '../Views/cart.php';
        } else {
            header('Location: /login');
            exit();
        }
    }

}