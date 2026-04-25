<?php

namespace Controllers;


use Model\FeedbackProduct;
use Model\Product;
use Request\FeedbackRequest;


class FeedbackController extends BaseController
{
    private FeedbackProduct $feedbackProductModel;

    public function __construct()
    {
        parent::__construct();
        $this->feedbackProductModel = new FeedbackProduct();
    }

    public function getFeedbackProduct()
    {
        if (!($this->authService->check())) {
            header('Location: /login');
            exit;
        }
    }

    public function handleFeedbackProduct(FeedbackRequest $request) {
        if (!$this->authService->check()) {
            header("Location: /login.php");
            exit;
        }

//      Получаем ID из POST (при сохранении) или из GET (при просмотре)
        $productId = $request->getProductId() ?? $_GET['id'] ?? null;
        $productId = (int)$productId;

        if (!$productId) {
            die("ID продукта не указан");
        }

        $product = Product::getOneById($productId);
        if (!$product) {
            die("Продукт не найден");
        }

        $data = $_POST;
        if (isset($data['review'])) {
            $name = $request->getName();
            $review = $request->getReview();
            $estimation = $request->getEstimation();

            $this->feedbackProductModel->saveFeedbackProductByAll($name, $productId, $review, $estimation);

            header("Location: /catalog");
            exit;
        }
        $averageRating = FeedbackProduct::getAverageRating($request->getProductId());
        $feedbacks = FeedbackProduct::getAllByProductId($request->getProductId());

        require_once '../Views/feedback_product_form.php';

    }

}