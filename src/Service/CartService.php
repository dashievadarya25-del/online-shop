<?php

declare(strict_types=1);

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

    public function getUserProducts(): array
    {
        $user = $this->authService->getCurrentUser();

        if ($user === null) {
            return [];
        }

        $userProducts = UserProduct::getAllByUserIdWithProducts($user->getId());

        foreach ($userProducts as $userProduct) {
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
            $this->userProduct->insertByUserProducts($user->getId(), $data->getProductId(), $data->getAmount());
        } else {
            $newAmount = $userProduct->getAmount() + $data->getAmount();

            $this->userProduct->updateByUserProducts($data->getProductId(), $newAmount, $user->getId());

        }
    }

    public function decreaseProducts(CartCreateDTO $data)
    {
        $user = $this->authService->getCurrentUser();

        $userProduct = $this->userProduct->getByProductIdUserId($data->getProductId(), $user->getId());

        if ($userProduct) {
            $newAmount = $userProduct->getAmount() - $data->getAmount();

            if ($newAmount > 0) {
                $this->userProduct->updateByUserProducts($data->getProductId(), $newAmount, $user->getId());
            } else {
                $this->userProduct->deleteByUserProducts($data->getProductId(), $user->getId());
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

    public function getProductAmount(int $productId): int
    {
        $user = $this->authService->getCurrentUser();
        if ($user === null) {
            return 0;
        }
        $userProduct = $this->userProduct->getByProductIdUserId($productId, $user->getId());
        return $userProduct ? $userProduct->getAmount() : 0;
    }

}