<?php

namespace Controllers;

use DTO\OrderCreateDTO;
use Model\Order;
use Model\OrderProduct;
use Model\Product;
use Model\UserProduct;
use Request\OrderRequest;
use Service\CartService;
use Service\OrderService;

class OrdersController extends BaseController
{
//    private Order $orderModel;
//    private OrderProduct $orderProduct;

//    private Product $productModel;
    private CartService $cartService;
    private OrderService $orderService;


    public function __construct()
    {
        parent::__construct();
//        $this->orderModel = new Order();
//        $this->orderProduct = new OrderProduct();
//        $this->productModel = new Product();
        $this->cartService = new CartService();
        $this->orderService = new OrderService();
    }


    public function getCheckoutForm()
    {
        if (!$this->authService->check()) {
            header('Location: /login');
            exit;
        }
        $userProducts = $this->cartService->getUserProducts();
        $total = $this->cartService->getSum();
        if(empty($userProducts))
        {
            header('Location: /catalog');
            exit;
        }

        require_once './../Views/order_form.php';
    }


    public function handleCheckout(OrderRequest $request)
    {
        if (!$this->authService->check()) {
            header('Location: /login');
            exit;
        }

        $errors = $request->regOrders();
        $userProducts = $this->cartService->getUserProducts();
        $total = $this->cartService->getSum();

        if (empty($errors)) {
            $dto = new OrderCreateDTO(
                $request->getContactName(),
                $request->getAddress(),
                $request->getContactPhone(),
                $request->getComment()
            );
            $this->orderService->placeOrder($dto);
            header('Location: /user-orders');
            exit;
        }

        require_once 'Views/order_form.php';
    }


    public function getAllOrders()
    {
        if (!$this->authService->check()) {
            header("Location: /login");
            exit();
        }

        $user = $this->authService->getCurrentUser();
        $userOrders = Order::getAllByUserId($user->getId()) ?? [];
        $newUserOrders = [];

        foreach ($userOrders as $userOrder) {

            $orderProducts = OrderProduct::getAllByOrderIdWithProducts($userOrder->getId()) ?? [];

            $newOrderProducts = [];
            $sum = 0;

            foreach ($orderProducts as $orderProduct) {
                $product = $orderProduct->getProduct();

                $amount = $orderProduct->getAmount();
                $price = $product->getPrice();
                $totalSum = $price * $amount;

                $newOrderProducts[] = [
                    'id' => $orderProduct->getId(),
                    'order_id' => $orderProduct->getOrderId(),
                    'product_id' => $orderProduct->getProductId(),
                    'amount' => $amount,
                    'name' => $product->getName(),
                    'price' => $price,
                    'totalSum' => $totalSum,
                ];

                $sum += $totalSum;
            }

            $newUserOrders[] = [
                'id' => $userOrder->getId(),
                'user_id' => $userOrder->getUserId(),
                'contact_name' => $userOrder->getContactName(),
                'contact_phone' => $userOrder->getContactPhone(),
                'address' => $userOrder->getAddress(),
                'comment' => $userOrder->getComment(),
                'total' => $sum,
                'products' => $newOrderProducts,
            ];
        }

        require_once './../Views/user_orders.php';
    }
}


