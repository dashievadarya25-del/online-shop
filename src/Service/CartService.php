<?php

namespace Service;

use DTO\CartCreateDTO;
use Model\UserProduct;
use Service\Auth\AuthInterface;
use Service\Auth\AuthSessionService;

class CartService
{
    private UserProduct $userProduct;
    private AuthInterface $authService;

    public function __construct()
    {
        $this->userProduct = new UserProduct();
        $this->authService = new AuthSessionService();
    }

    public function getUserProducts():array
    {
        $user = $this->authService->getCurrentUser();
        $userProducts = $this->userProduct->getAllUserProductsByUserId($user->getId());
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




}