<?php
namespace Controllers;
// test
use DTO\CartCreateDTO;
use Request\AddProductRequest;
use Request\DecreaseRequest;
use Service\CartService;


class CartController extends BaseController
{
      private CartService $cartService;


    public function __construct()
    {
        parent::__construct();

        $this->cartService = new CartService();
    }
    public function getcart()
    {
        if (!$this->authService->check()) {
            header("Location: /login");
            exit;
        }
        $userProducts = $this->cartService->getUserProducts();

        require_once '../Views/cart.php';
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
//            $user = $this->authService->getCurrentUser();

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