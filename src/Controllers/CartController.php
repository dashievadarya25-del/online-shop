<?php
namespace Controllers;

use DTO\CartCreateDTO;
use Model\Product;
use Model\UserProduct;
use Request\AddProductRequest;
use Request\DecreaseRequest;
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
            $userProducts = $this->cartService->getUserProducts();

                    $products = [];
                    foreach ($userProducts as $userProduct) {
                        // Получаем объект продукта напрямую из модели
                        $product = $this->productModel->getByProductId($userProduct->getProductId());

                        if ($product) {
                            $product->amount = $userProduct->getAmount();

                            // Складываем объект в массив для вьюхи
                            $products[] = $product;
                        }
                    }



            //print_r($products);
            require_once '../Views/cart.php';
//        } else {
//            header('Location: /login');
//            exit();
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

            $dto = new CartCreateDTO($request->getProductId(), $request->getAmount());
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
//            $user = $this->authService->getCurrentUser();

            $dto = new CartCreateDTO($request->getProductId(), $request->getAmount());


            // Получаем текущие данные товара в корзине
            $this->cartService->decreaseProducts($dto);


            header('Location: /catalog');
            exit;
        } else {
            print_r($errors);
        }
    }



}