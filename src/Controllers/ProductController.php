<?php
namespace Controllers;
use Model\Product;
use Model\UserProduct;
use Service\AuthService;


class ProductController extends BaseController
{
    private Product $productModel;

    private UserProduct $userProductModel;

    public function __construct()
    {
        parent::__construct();
        $this->productModel = new Product();
        $this->userProductModel = new UserProduct();

    }
    public function getCatalog()
    {


        if ($this->authService->check()) {

            $products = $this->productModel->getAll();

            require_once '../Views/catalog_form.php';
        } else {
            header("Location: /login");
        }
    }

    public function getaddProducts()
    {
        require_once '../Views/add_product_form.php';
    }

    public function addProduct()
    {

        if (!($this->authService->check())) {
            header('Location: /login');
            exit;
        }


        $errors = $this->addproductValidate($_POST);
        //print_r($errors);

        if (empty($errors)) {
            $user = $this->authService->getCurrentUser();

            $productId = $_POST['product_id'];
            $amount = $_POST['amount'];

            $userProduct = $this->userProductModel->getByProductIdUserId($productId, $user->getId());

            if (!$userProduct) {
                $this->userProductModel->insertByUserproducts($productId, $amount);
            } else {
                $amount = $userProduct->getAmount() + $_POST['amount'];

                $this->userProductModel->updateByUserproducts($productId, $amount, $user->getId());

            }
            header('Location: /catalog');
        }
    }

    function addproductValidate(array $data): array
    {
        $errors = [];

        if (isset($data['product_id'])) {
            $productId = (int)$data['product_id'];

//  id == productId


            $data = $this->productModel->getByProductId($productId);

            if ($data === false) {
                $errors['product_id'] = 'Product id does not exist';
            }
        } else {
            $errors['product_id'] = 'Product id is required';
        }

        return $errors;

    }

    public function getdecreaseProducts()
    {
        require_once '../Views/decrease_product.php';
    }

    public function decreaseProducts()
    {
        if (!$this->authService->check()) {
            header('Location: /login');
            exit;
        }

        $errors = $this->removeProductValidate($_POST);
        if (empty($errors)) {
            $user = $this->authService->getCurrentUser();
            $productId = $_POST['product_id'];

            // Получаем текущие данные товара в корзине
            $userProduct = $this->userProductModel->getByProductIdUserId($productId, $user->getId());



            if ($userProduct !== false) {
                // уменьшаем на 1
                $amount = $userProduct->getAmount() - 1;

                if ($amount > 0) {
                    // Если после уменьшения товар еще остается, обновляем количество
                    $this->userProductModel->updateByUserproducts($productId, $amount, $user->getId());
                } else {
                    // Если количество стало 0, товар нужно удаляем из корзины
                    $this->userProductModel->deleteByUserproducts($productId, $user->getId());
                }
            }

            header('Location: /catalog');
            exit;
        } else {
            print_r($errors);
        }
    }

    function removeProductValidate(array $data): array
    {
                $errors = [];

                // 1. Проверка наличия ID продукта в запросе
                if (isset($data['product_id'])) {
                    $productId = (int)$data['product_id'];

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

    public function getFeedback()
    {
        require_once '../Views/feedback_form.php';
    }

    public function handleFeedback()
    {

    }





}