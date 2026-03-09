<?php

namespace Request;

use Model\Product;

class AddProductRequest
{
    private Product $productModel;
    public function __construct(private array $data)
    {
        $this->productModel = new Product();

    }

    public function getProductId(): int
    {
        return $this->data['product_id'];
    }

    public function getAmount(): int
    {
        return $this->data['amount'];
    }

    public function addproductValidate(): array
    {
        $errors = [];

        if (isset($this->data['product_id'])) {
            $productId = $this->data['product_id'];

            $data = $this->productModel->getByProductId($productId);

            if ($data === false) {
                $errors['product_id'] = 'Product id does not exist';
            }
        } else {
            $errors['product_id'] = 'Product id is required';
        }

        return $errors;

    }






}