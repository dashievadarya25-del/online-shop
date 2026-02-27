<?php

namespace Controllers;

use Model\FeedbackProduct;
use Model\Product;

class FeedbackController extends BaseController
{
    private Product $productModel;
    private FeedbackProduct $feedbackProductModel;
    public function __construct()
    {
        parent::__construct();
        $this->productModel = new Product();
        $this->feedbackProductModel = new FeedbackProduct();
    }

    public function getFeedbackProduct()
    {
        if (!($this->authService->check())) {
            header('Location: /login');
            exit;
        }
    }

    public function handleFeedbackProduct() {
        if (!$this->authService->check()) {
            header("Location: /login.php");
            exit;
        }

        // Получаем ID из POST (при сохранении) или из GET (при просмотре)
        $productId = $_POST['product_id'] ?? $_GET['id'] ?? null;
        $productId = (int)$productId;

        if (!$productId) {
            die("ID продукта не указан");
        }

        $product = $this->productModel->getOneById($productId);
        if (!$product) {
            die("Продукт не найден");
        }

        // Сохранение (POST)
        if (isset($_POST['review'])) {
            $name = $_POST['name'];
            $review = $_POST['review'];
            $estimation = $_POST['estimation'];

            $this->feedbackProductModel->saveFeedbackProductByAll($name, $productId, $review, $estimation);

            header("Location: /catalog");
            exit;
        }


        $averageRating = $this->feedbackProductModel->getAverageRating($productId);
        $feedbacks = $this->feedbackProductModel->getAllByProductId($productId);
        require_once '../Views/feedback_product_form.php';
    }

}