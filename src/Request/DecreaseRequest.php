<?php

namespace Request;



use Model\Product;

class DecreaseRequest
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

    function removeProductValidate(): array
    {
        $errors = [];

        // 1. Проверка наличия ID продукта в запросе
        if (isset($this->data['product_id'])) {
            $productId = $this->data['product_id'];

            // Получаем данные о продукте из базы
            $data = $this->productModel->getByProductId($productId);

            if (!$data) {
                $errors['product_id'] = "Product id does not exist.";
            }

        } else {
            $errors['product_id'] = "Product id is required.";
        }

        return $errors;
    }

}