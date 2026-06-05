<?php

declare(strict_types=1);

namespace Controllers;

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

    public function getCart()
    {
        if (!$this->authService->check()) {
            header("Location: /login");
            exit;
        }
        $userProducts = $this->cartService->getUserProducts();
        $cartTotal = $this->cartService->getSum();

        require_once '../Views/cart.php';
    }

    public function getAddProducts()
    {
        require_once '../Views/add_product_form.php';
    }

    public function addProduct(AddProductRequest $request)
    {
        if (!($this->authService->check())) {
            if ($this->isAjax()) {
                $this->jsonResponse(['success' => false, 'message' => 'Not authenticated'], 401);
            }
            header('Location: /login');
            exit;
        }

        $errors = $request->addProductValidate();

        if (empty($errors)) {
            $dto = new CartCreateDTO($request->getProductId(), $request->getAmount());
            $this->cartService->addProduct($dto);
        }

        if ($this->isAjax()) {
            $this->jsonResponse([
                'success' => empty($errors),
                'errors' => $errors,
                'newAmount' => $this->cartService->getProductAmount($request->getProductId()),
                'cartTotal' => $this->cartService->getSum(),
            ]);
        }

        header('Location: /catalog');
    }

    public function getDecreaseProducts()
    {
        require_once '../Views/decrease_product.php';
    }

    public function decreaseProducts(DecreaseRequest $request)
    {
        if (!$this->authService->check()) {
            if ($this->isAjax()) {
                $this->jsonResponse(['success' => false, 'message' => 'Not authenticated'], 401);
            }
            header('Location: /login');
            exit;
        }

        $errors = $request->removeProductValidate();
        if (empty($errors)) {
            $dto = new CartCreateDTO($request->getProductId(), $request->getAmount());
            $this->cartService->decreaseProducts($dto);

            if ($this->isAjax()) {
                $this->jsonResponse([
                    'success' => true,
                    'newAmount' => $this->cartService->getProductAmount($request->getProductId()),
                    'cartTotal' => $this->cartService->getSum(),
                ]);
            }

            header('Location: /catalog');
            exit;
        } else {
            if ($this->isAjax()) {
                $this->jsonResponse(['success' => false, 'errors' => $errors], 422);
            }
            require_once '../Views/decrease_product.php';
        }
    }

}