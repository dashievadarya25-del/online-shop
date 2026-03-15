<?php
namespace Controllers;
use Model\Product;
use Model\UserProduct;


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

}