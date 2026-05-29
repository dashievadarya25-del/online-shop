<?php

declare(strict_types=1);

namespace Service;

use DTO\OrderCreateDTO;
use Model\Order;
use Model\OrderProduct;
use Model\Product;
use Model\User;
use Model\UserProduct;
use Service\Auth\AuthInterface;
use Service\Auth\AuthSessionService;

class OrderService
{
    private UserProduct $userProduct;
    private OrderProduct $orderProduct;
    private Order $orderModel;
    private AuthInterface $authService;
    private CartService $cartService;

    public function __construct()
    {
        $this->userProduct = new UserProduct();
        $this->orderProduct = new OrderProduct();
        $this->orderModel = new Order();
        $this->authService = new AuthSessionService();
        $this->cartService = new CartService();
    }

    public function placeOrder(OrderCreateDTO $data): int
    {
        $sum = $this->cartService->getSum();
        if ($sum < 1000) {
            throw new \Exception('Для оформления заказа сумма корзины должна быть больше 1000');
        }

        $user = $this->authService->getCurrentUser();

        $userProducts = UserProduct::getAllUserProductsByUserId($user->getId());

        $orderId = $this->orderModel->create(
            $data->getContactName(),
            $data->getAddress(),
            $data->getContactPhone(),
            $data->getComment(),
            $user->getId()
        );

        foreach ($userProducts as $userProduct) {
            $this->orderProduct->create(
                $orderId,
                $userProduct->getProductId(),
                $userProduct->getAmount()
            );
        }

        $this->userProduct->deleteByUserId($user->getId());

        return $orderId;
    }

}