<?php

require_once '../Core/App.php';

$app = new App();
$app->run();

//$requestUri = $_SERVER['REQUEST_URI'];
//$requestMethod = $_SERVER['REQUEST_METHOD'];
//
//if ($requestUri === '/registration') {
//    require_once '../Controllers/UserController.php';
//    $user = new UserController();
//    if ($requestMethod === 'GET') {
//        $user->getRegistrate();
//    } elseif ($requestMethod === 'POST') {
//        $user->registrate();
//    }
//} elseif ($requestUri === '/login') {
//    require_once '../Controllers/UserController.php';
//    $user = new UserController();
//    if ($requestMethod === 'GET') {
//        $user->getLogin();
//    } elseif ($requestMethod === 'POST') {
//        $user->login();
//    }
//} elseif ($requestUri === '/catalog') {
//    require_once '../Controllers/ProductController.php';
//    $products = new ProductController();
//    if ($requestMethod === 'POST') {
//        $products->getCatalog();
//    } elseif ($requestMethod === 'GET') {
//        $products->catalog();
//    }
//} elseif ($requestUri === '/edit-profile') {
//    require_once '../Controllers/UserController.php';
//    $user = new UserController();
//    if ($requestMethod === 'GET') {
//        $user->getEditprofile();
//    } elseif ($requestMethod === 'POST') {
//        $user->editProfile();
//    }
//} elseif ($requestUri === '/profile') {
//    require_once '../Controllers/UserController.php';
//    $user = new UserController();
//    if ($requestMethod === 'GET') {
//        $user->profile();
//    } elseif ($requestMethod === 'POST') {
//        $user->getProfile();
//    }
//} elseif ($requestUri === '/add-product') {
//    require_once '../Controllers/ProductController.php';
//    $products = new ProductController();
//    if ($requestMethod === 'GET') {
//        $products->getaddProducts();
//    } elseif ($requestMethod === 'POST') {
//       $products->addProduct();
//    }
//} else {
//    require_once './404.php';
//}

