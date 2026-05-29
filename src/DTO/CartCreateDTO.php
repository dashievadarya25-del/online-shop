<?php

declare(strict_types=1);

namespace DTO;

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