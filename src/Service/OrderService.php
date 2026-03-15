<?php

namespace Service;

use DTO\OrderCreateDTO;
use Model\Order;
use Model\OrderProduct;
use Model\User;
use Model\UserProduct;
use Service\Auth\AuthInterface;
use Service\Auth\AuthSessionService;

class OrderService
{
    protected User $userModel;
    private UserProduct $userProduct;
    private OrderProduct $orderProduct;
    private Order $orderModel;
    private AuthInterface $authService;
    public function __construct()
    {
        $this->userProduct = new UserProduct();
        $this->orderProduct = new OrderProduct();
        $this->orderModel = new Order();
        $this->userModel = new User();
        $this->authService = new AuthSessionService();
    }

    public function placeOrder(OrderCreateDTO $data)
    {
        $user = $this->authService->getCurrentUser();
        // 1. Создаем основной заказ
        $orderId = $this->orderModel->create(
            $data->getContactName(),
            $data->getAddress(),
            $data->getContactPhone(),
            $data->getComment(),
            $user->getId()
        );

        // 2. Получаем товары из корзины пользователя
        $userProducts = $this->userProduct->getAllByUserId($user->getId());

        // 3. Переносим товары в состав заказа
        foreach ($userProducts as $userProduct) {
            $this->orderProduct->create(
                $orderId,
                $userProduct->getProductId(),
                $userProduct->getAmount()
            );
        }

        // 4. Очищаем корзину
        $this->userProduct->deleteByUserId($user->getId());

        return $orderId;
    }


}