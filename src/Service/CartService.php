<?php

namespace Service;

use DTO\CartCreateDTO;
use Model\UserProduct;

class CartService
{
    private UserProduct $userProduct;

    public function __construct()
    {
        $this->userProduct = new UserProduct();
    }

    public function addProduct(CartCreateDTO $data)
    {



//        $productId = $_POST['product_id'];
//        $amount = $_POST['amount'];

        $userProduct = $this->userProduct->getByProductIdUserId($data->getProductId(), $data->getUser()->getId());

        if (!$userProduct) {
            $this->userProduct->insertByUserproducts($data->getUser()->getId(), $data->getProductId(), $data->getAmount());
        } else {
            $newAmount = $userProduct->getAmount() + $data->getAmount();

            $this->userProduct->updateByUserproducts($data->getProductId(), $newAmount, $data->getUser()->getId());

        }
    }

    public function decreaseProducts(CartCreateDTO $data)
    {

        $userProduct = $this->userProduct->getByProductIdUserId($data->getProductId(), $data->getUser()->getId());

        if ($userProduct) {
            // уменьшаем на 1
            $newAmount = $userProduct->getAmount() - 1;

            if ($newAmount > 0) {
                // Если после уменьшения товар еще остается, обновляем количество
                $this->userProduct->updateByUserproducts($data->getProductId(), $newAmount, $data->getUser()->getId());
            } else {
                // Если количество стало 0, товар нужно удаляем из корзины
                $this->userProduct->deleteByUserproducts($data->getProductId(), $data->getUser()->getId());
            }
        }

    }




}