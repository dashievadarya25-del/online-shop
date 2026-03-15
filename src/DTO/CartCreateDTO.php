<?php

namespace DTO;

use Model\Product;
use Model\User;

class CartCreateDTO
{
    public function __construct(private int $productId, private int $amount)
    {

    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

}