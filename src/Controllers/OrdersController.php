<?php

namespace Controllers;

use Model\Order;
use Model\OrderProduct;
use Model\UserProduct;

class OrdersController
{
    private Order $orderModel;

    public function __construct()
    {
        $this->orderModel = new Order();
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
            $userProductModel = new UserProduct();
            $userProducts = $userProductModel->getAllByUserId($userId);

            $orderProduct = new OrderProduct();

            foreach ($userProducts as $userProduct) {
                $productId = $userProduct['product_id'];
                $amount = $userProduct['amount'];

                $orderProduct->create($orderId, $productId, $amount);

            }
            $userProductModel->deleteByUserId($userId);

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
}


