<?php

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestUri === '/registration') {
    require_once './classes/User.php';
    $user = new User();
    if ($requestMethod === 'GET') {
        $user->getRegistrate();
    } elseif ($requestMethod === 'POST') {
        $user->registrate();
    }
} elseif ($requestUri === '/login') {
    require_once './classes/User.php';
    $user = new User();
    if ($requestMethod === 'GET') {
        $user->getLogin();
    } elseif ($requestMethod === 'POST') {
        $user->login();
    }
} elseif ($requestUri === '/catalog') {
    require_once './classes/Products.php';
    $products = new Products();
    if ($requestMethod === 'POST') {
        $products->getCatalog();
    } elseif ($requestMethod === 'GET') {
        $products->catalog();
    }
} elseif ($requestUri === '/edit-profile') {
    require_once './classes/User.php';
    $user = new User();
    if ($requestMethod === 'GET') {
        $user->editProfile();
    } elseif ($requestMethod === 'POST') {
        $user->getEditprofile();
    }
} elseif ($requestUri === '/profile') {
    require_once './classes/User.php';
    $user = new User();
    if ($requestMethod === 'GET') {
        $user->profile();
    } elseif ($requestMethod === 'POST') {
        $user->getProfile();
    }
} elseif ($requestUri === '/add-product') {
    require_once './classes/Products.php';
    $products = new Products();
    if ($requestMethod === 'GET') {
        $products->getaddProducts();
    } elseif ($requestMethod === 'POST') {
       $products->addProduct();
    }
} else {
    require_once './404.php';
}

