<?php

namespace Request;



use Model\Product;

class DecreaseRequest
{
    public function __construct(private array $data)
    {

    }

    public function getProductId(): int
    {
        return $this->data['product_id'];
    }
    public function getAmount(): int
    {
        return $this->data['amount'];
    }

    function removeProductValidate(): array
    {
        $errors = [];

        if (isset($this->data['product_id'])) {
            $productId = $this->data['product_id'];

            $data = Product::getByProductId($productId);

            if (!$data) {
                $errors['product_id'] = "Product id does not exist.";
            }

        } else {
            $errors['product_id'] = "Product id is required.";
        }

        return $errors;
    }

}