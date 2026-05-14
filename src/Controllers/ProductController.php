<?php

namespace Controllers;

use Model\Product;
use Model\UserProduct;

class ProductController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getCatalog()
    {
        if ($this->authService->check()) {

            $products = Product::getAll();

            require_once '../Views/catalog_form.php';
        } else {
            header("Location: /login");
        }
    }

//
//// Отображение страницы создания отзыва
//    public function getFeedbackProduct() {
//        // Проверка авторизации
//        if (!$this->authService->check()) {
//            header("Location: /login");
//            exit;
//        }
//
//        // Получение ID продукта из GET-запроса
//        $productId = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;
//
//        if ($productId <= 0) {
//            header("Location: /catalog");
//            exit;
//        }
//
//        // Получение данных конкретного продукта для отображения на странице
//        // Предполагается наличие метода getById() в вашем классе Product
//        $product = Product::getOneById($productId);
//
//        if (!$product) {
//            // Если продукт не найден в базе данных
//            header("Location: /catalog");
//            exit;
//        }
//
//        // Подключение представления страницы отзыва
//        require_once '../Views/feedback_form.php';
//    }
//
//// Обработка отправки формы отзыва
//    public function handleFeedbackProduct() {
//        // Проверка авторизации
//        if (!$this->authService->check()) {
//            header("Location: /login");
//            exit;
//        }
//
//        // Проверка типа запроса
//        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
//            header("Location: /catalog");
//            exit;
//        }
//
//        // Валидация входных данных
//        $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
//        $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 5;
//        $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';
//
//        if ($productId <= 0 || empty($comment)) {
//            // Возврат на форму с ошибкой (можно передать через сессию)
//            header("Location: /feedback?product_id=" . $productId . "&error=empty_fields");
//            exit;
//        }
//
//        // Получение ID текущего авторизованного пользователя
//        // Замените на ваш метод получения ID пользователя
//        $userId = $this->authService->getUserId();
//
//        // Сохранение отзыва в базу данных
//        // Предполагается наличие модели Feedback с методом create()
//        $saved = Feedback::create($productId, $userId, $rating, $comment);
//
//        if ($saved) {
//            // Перенаправление на страницу товара или каталог с успешным статусом
//            header("Location: /catalog?success=feedback_added");
//        } else {
//            header("Location: /feedback?product_id=" . $productId . "&error=save_failed");
//        }
//        exit;
//    }
}