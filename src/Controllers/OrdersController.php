<?php

namespace Controllers;

use Model\Order;
use Model\OrderProduct;
use Model\Product;
use Model\UserProduct;

class OrdersController
{
    private Order $orderModel;
    private OrderProduct $orderProductModel;

    private UserProduct $userProductModel;

    private Product $productModel;


    public function __construct()
    {
        $this->orderModel = new Order();
        $this->orderProductModel = new OrderProduct();
        $this->userProductModel = new UserProduct();
        $this->productModel = new Product();
    }


    public function getCheckoutForm()
    {

        require_once './../Views/order_form.php';
    }


    public function handleCheckout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['userId'])) {
            header("Location: /login");
            exit;
        }
        $errors = $this->regOrders($_POST);

// добавляем в БД, если нет ошибок
        if (empty($errors)) {
            $address = $_POST['address'];
            $contact_phone = $_POST['contact_phone'];
            $contact_name = $_POST['contact_name'];
            $comment = $_POST['comment'];
            $userId = $_SESSION['userId'];

            $orderId = $this->orderModel->create($contact_name, $address, $contact_phone, $comment, $userId);

            $userProducts = $this->userProductModel->getAllByUserId($userId);

            foreach ($userProducts as $userProduct) {
                $productId = $userProduct->getProductId();
                $amount = $userProduct->getAmount();

                $this->orderProductModel->create($orderId, $productId, $amount);

            }
            $this->userProductModel->deleteByUserId($userId);

        }
        require_once '../Views/order_form.php';
    }

    private function regOrders(array $data): array
    {
        $errors = [];

        //объявление и валидация данных
        if (isset($data['contact_name'])) {
            $contact_name = $data['contact_name'];
            if (strlen($contact_name) < 2) {
                $errors['contact_name'] = "Name must be at least 2 characters";
            }
        } else {
            $errors['contact_name'] = "Name is required";
        }

        if (isset($data['address'])) {
            $address = $data['address'];

            if (strlen($address) < 5) {
                $errors['address'] = 'address не должен быть меньше 5 символов';
            }
        }

        if (isset($data['contact_phone'])) {
            $contact_phone = $data ['contact_phone'];

            if (strlen($contact_phone) < 11) {
                $errors['phone'] = 'должно содержать не меньше 11 символов';
            }
        }
        return $errors;
    }

    public function getAllOrders()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['userId'])) {
            header("Location: /login");
            exit();
        }
        $userId = $_SESSION['userId'];

        $userOrders = $this->orderModel->getAllByUserId($userId);

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

           $orderProducts = $this->orderProductModel->getAllByOrderId($userOrder->getId());


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


