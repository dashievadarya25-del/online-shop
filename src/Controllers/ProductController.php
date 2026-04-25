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

}