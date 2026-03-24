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

        $userOrders = Order::getAllByUserId($user->getId());

        if ($userOrders === null) {
            $userOrders = [];
        }
        $newUserOrders = [];

        foreach ($userOrders as $userOrder) {
           $orderProducts = OrderProduct::getAllByOrderId($userOrder->getId());
            if ($orderProducts === null) {
                $orderProducts = [];
            }

            $newOrderProducts = [];
            $sum = 0;

            foreach ($orderProducts as $orderProduct) {
                $product = Product::getOneById($orderProduct->getProductId());
                $orderProductData = [
                    'id' => $orderProduct->getProductId(),
                    'order_id' => $orderProduct->getOrderId(),
                    'product_id' => $orderProduct->getProductId(),
                    'amount' => $orderProduct->getAmount(),
                    'name' => $product->getName(),
                    'price' => $product->getPrice(),
                    'totalSum' => $product->getPrice() * $orderProduct->getAmount(),
                    ];

                $newOrderProducts[] = $orderProductData;

                $sum = $sum + $orderProductData['totalSum'];
            }

            $userOrderData = [
                'id' => $userOrder->getId(),
                'user_id' => $userOrder->getUserId(),
                'contact_name' => $userOrder->getContactName(),
                'contact_phone' => $userOrder->getContactPhone(),
                'address' => $userOrder->getAddress(),
                'comment' => $userOrder->getComment(),
                'total' => $sum,
                'products' => $newOrderProducts,
            ];

            $newUserOrders[] = $userOrderData;

        }
        require_once './../Views/user_orders.php';
    }
}


