<?php

namespace Service;

use DTO\CartCreateDTO;
use Model\Product;
use Model\UserProduct;
use Service\Auth\AuthInterface;
use Service\Auth\AuthSessionService;

class CartService
{
    private UserProduct $userProduct;
    private AuthInterface $authService;
//    private Product $productModel;

    public function __construct()
    {
        $this->userProduct = new UserProduct();
        $this->authService = new AuthSessionService();
//        $this->productModel = new Product();
    }

    public function getUserProducts():array
    {
        $user = $this->authService->getCurrentUser();

        if($user === null) {
            return [];
        }

        $userProducts = UserProduct::getAllByUserIdWithProducts($user->getId());
        if ($userProducts === null) {
            header('Location: /catalog');
        }
//        var_dump($userProducts);
//        die();
        foreach ($userProducts as $userProduct)
        {
//            $product = Product::getOneById($userProduct->getProductId());
//            if ($product) {
//                $userProduct->setProduct($product);

                $totalSum = $userProduct->getAmount() * $userProduct->getProduct()->getPrice();//получили сумму
                $userProduct->setTotalSum($totalSum);//и привязываем к $userProduct
        }
        return $userProducts;
    }



    public function addProduct(CartCreateDTO $data)
    {
        $user = $this->authService->getCurrentUser();
        $userProduct = $this->userProduct->getByProductIdUserId($data->getProductId(), $user->getId());


        if (!$userProduct) {
            $this->userProduct->insertByUserproducts($user->getId(), $data->getProductId(), $data->getAmount());
        } else {
            $newAmount = $userProduct->getAmount() + $data->getAmount();

            $this->userProduct->updateByUserproducts($data->getProductId(), $newAmount, $user->getId());

        }
    }

    public function decreaseProducts(CartCreateDTO $data)
    {
        $user = $this->authService->getCurrentUser();

        $userProduct = $this->userProduct->getByProductIdUserId($data->getProductId(), $user->getId());

        if ($userProduct) {
            // уменьшаем на 1
            $newAmount = $userProduct->getAmount() - 1;

            if ($newAmount > 0) {
                // Если после уменьшения товар еще остается, обновляем количество
                $this->userProduct->updateByUserproducts($data->getProductId(), $newAmount, $user->getId());
            } else {
                // Если количество стало 0, товар нужно удаляем из корзины
                $this->userProduct->deleteByUserproducts($data->getProductId(), $user->getId());
            }
        }

    }

    public function getSum(): int
    {
        $total = 0;
        foreach ($this->getUserProducts() as $userProduct) {
            $total += $userProduct->getTotalSum();
        }
        return $total;
    }





}