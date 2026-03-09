<?php

namespace Controllers;

use DTO\OrderCreateDTO;
use Model\Order;
use Model\OrderProduct;
use Model\Product;
use Model\UserProduct;
use Request\OrderRequest;
use Service\AuthService;
use Service\OrderService;

class OrdersController extends BaseController
{
    private Order $orderModel;
    private OrderProduct $orderProduct;

    private UserProduct $userProduct;

    private Product $productModel;
    private OrderService $orderService;


    public function __construct()
    {
        parent::__construct();
        $this->orderModel = new Order();
        $this->orderProduct = new OrderProduct();
        $this->userProduct = new UserProduct();
        $this->productModel = new Product();
        $this->orderService = new OrderService();
    }


    public function getCheckoutForm()
    {


        require_once './../Views/order_form.php';
    }


    public function handleCheckout(OrderRequest $request) {
        // Проверка авторизации
        if (!$this->authService->check()) {
            header('Location: /login');
            exit;
        }

        $errors = $request->regOrders();
        $user = $this->authService->getCurrentUser();

        if (empty($errors)) {
            $dto = new OrderCreateDTO(
                $request->getContactName(),
                $request->getAddress(),
                $request->getContactPhone(),
                $request->getComment(),
                $user
            );

                $this->orderService->placeOrder($dto);

        }

        require_once '../Views/order_form.php';
    }




    public function getAllOrders()
    {
        if (!$this->authService->check()) {
            header("Location: /login");
            exit();
        }
        $user = $this->authService->getCurrentUser();

        $userOrders = $this->orderModel->getAllByUserId($user->getId());

        if ($userOrders === null) {
            $userOrders = [];
        }
//        $userOrders = [
//            [
//                'id' => 1,
//                'user_id' => 1,
//                'contact_name' => 'test',
//                'address' => 'test',
//                'contact_phone' => 'test',
//                'comment' => 'test',
//            ],
//            [
//                'id' => 2,
//                'user_id' => 1,
//                'contact_name' => 'test',
//                'address' => 'test',
//                'contact_phone' => 'test',
//                'comment' => 'test',
//            ],
//        ];

        $newUserOrders = [];

        foreach ($userOrders as $userOrder) {
            //$userOrder = [
//                'id' => 1,
//                'user_id' => 1,
//                'contact_name' => 'test',
//                'address' => 'test',
//                'contact_phone' => 'test',
//                'comment' => 'test',
//            ],

           $orderProducts = $this->orderProduct->getAllByOrderId($userOrder->getId());


//            $orderProducts = [
//                [
//                    'id' => 1,
//                    'order_id' => 1,
//                    'product_id' => 1,
//                    'amount' => 1,
//                ],
//                [
//                    'id' => 2,
//                    'order_id' => 1,
//                    'product_id' => 2,
//                    'amount' => 2,
//                ],
//            ];
            if ($orderProducts === null) {
                $orderProducts = [];
            }

            $newOrderProducts = [];
            $sum = 0;

            foreach ($orderProducts as $orderProduct) {
//                $orderProduct = [
//                    'id' => 1,
//                    'order_id' => 1,
//                    'product_id' => 1,
//                    'amount' => 1,
//                ];

                $product = $this->productModel->getOneById($orderProduct->getProductId());
//                $product = [
//                    'id' => 1,
//                    'name' => 'вафли',
//                    'description' => 'описание',
//                    'price' => 100,
//                    'image_url' => 'рисунок',
//                ];
                $orderProductData = [
                    'id' => $orderProduct->getProductId(),
                    'order_id' => $orderProduct->getOrderId(),
                    'product_id' => $orderProduct->getProductId(),
                    'amount' => $orderProduct->getAmount(),
                    'name' => $product->getName(),
                    'price' => $product->getPrice(),
                    'totalSum' => $product->getPrice() * $orderProduct->getAmount(),
                    ];

//                $orderProduct = [
//                    'id' => 1,
//                    'order_id' => 1,
//                    'product_id' => 1,
//                    'amount' => 1,
//                    'name' => $product['name'],
//                    'price' => $product['price'],
//                    'totalSum' => $orderProduct['price'] * $orderProduct['amount'],
//                ];
                $newOrderProducts[] = $orderProductData;

                $sum = $sum + $orderProductData['totalSum'];
            }
//            $userOrder['total'] = $sum;
//            $userOrder['products'] = $newOrderProducts;
//            $newUserOrders[] = $userOrder;
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


