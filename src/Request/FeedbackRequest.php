<?php

declare(strict_types=1);

namespace Request;

class FeedbackRequest
{
    public function __construct(private array $data)
    {
    }

    public function getName(): string
    {
        return $this->data['name'];
    }

    public function getProductId(): int
    {
        return (int) $this->data['product_id'];
    }

    public function getReview(): string
    {
        return $this->data['review'];
    }

    public function getEstimation(): int
    {
        return (int) $this->data['estimation'];
    }


}