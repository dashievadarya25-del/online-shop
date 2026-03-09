<?php
namespace Controllers;

use DTO\CartCreateDTO;
use Model\Product;
use Model\UserProduct;
use Request\AddProductRequest;
use Request\DecreaseRequest;
use Service\AuthService;
use Service\CartService;

class CartController extends BaseController
{
    private Product $productModel;
    private UserProduct $userProduct;
    private CartService $cartService;
    public function __construct()
    {
        parent::__construct();
        $this->productModel = new Product();
        $this->userProduct = new UserProduct();
        $this->cartService = new CartService();
    }
    public function getcart()
    {
        if ($this->authService->check()) {
            $user = $this->authService->getCurrentUser();

            $userProducts = $this->userProduct->getAllUserProductsByUserId($user->getId());

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


    public function getaddProducts()
    {
        require_once '../Views/add_product_form.php';
    }

    public function addProduct(AddProductRequest $request)
    {

        if (!($this->authService->check())) {
            header('Location: /login');
            exit;
        }
        $errors = $request->addproductValidate();
        //print_r($errors);

        if (empty($errors)) {
            $user = $this->authService->getCurrentUser();

            $dto = new CartCreateDTO($user, $request->getProductId(),$request->getAmount());
            $this->cartService->addProduct($dto);
        }

        header('Location: /catalog');

    }





    public function getdecreaseProducts()
    {
        require_once '../Views/decrease_product.php';
    }

    public function decreaseProducts(DecreaseRequest $request)
    {
        if (!$this->authService->check()) {
            header('Location: /login');
            exit;
        }

        $errors = $request->removeProductValidate();
        if (empty($errors)) {
            $user = $this->authService->getCurrentUser();

            $dto = new CartCreateDTO($user, $request->getProductId(), $request->getAmount());


            // Получаем текущие данные товара в корзине
            $this->cartService->decreaseProducts($dto);


            header('Location: /catalog');
            exit;
        } else {
            print_r($errors);
        }
    }



}