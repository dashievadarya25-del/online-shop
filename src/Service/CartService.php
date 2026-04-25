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

    public function __construct()
    {
        $this->userProduct = new UserProduct();
        $this->authService = new AuthSessionService();
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

        foreach ($userProducts as $userProduct)
        {
            $totalSum = $userProduct->getAmount() * $userProduct->getProduct()->getPrice();
            $userProduct->setTotalSum($totalSum);
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
            $newAmount = $userProduct->getAmount() - 1;

            if ($newAmount > 0) {
                $this->userProduct->updateByUserproducts($data->getProductId(), $newAmount, $user->getId());
            } else {
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