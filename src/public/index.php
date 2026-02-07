<?php

use Controllers\CartController;
use Controllers\OrdersController;
use Controllers\ProductController;
use Controllers\UserController;

$autoload = function (string $classname) {
    //  ./../Core/App.php
    $path = str_replace('\\', '/', $classname); //Core/App
    $path = $path . '.php'; // Core/App.php
    $path = './../' . $path;

    if (file_exists($path)) {
        require_once $path;
        return true;
    }

    return false;
};

spl_autoload_register($autoload);

$app = new Core\App();
$app->addRoute('/registration', 'GET', UserController::class, 'getRegistrate');
$app->addRoute('/registration', 'POST', UserController::class, 'registrate');
$app->addRoute('/login', 'GET', UserController::class, 'getLogin');
$app->addRoute('/login', 'POST', UserController::class, 'login');
$app->addRoute('/catalog', 'GET', ProductController::class, 'getCatalog');
$app->addRoute('/edit-profile', 'GET', UserController::class, 'getEditprofile');
$app->addRoute('/edit-profile', 'POST', UserController::class, 'editProfile');
$app->addRoute('/profile', 'GET', UserController::class, 'profile');
$app->addRoute('/add-product', 'GET', ProductController::class, 'getaddProducts');
$app->addRoute('/add-product', 'POST', ProductController::class, 'addProduct');
$app->addRoute('/cart', 'GET', CartController::class, 'getcart');
$app->addRoute('/create-order', 'GET', OrdersController::class, 'getCheckoutForm');
$app->addRoute('/create-order', 'POST', OrdersController::class, 'handleCheckout');
$app->addRoute('/user-order', 'GET', OrdersController::class, 'getAllOrders');


$app->run();
//'/registration' => [
//    'GET' => [
//        'class' => UserController::class,
//        'method' => 'getRegistrate',
//    ],
//    'POST' => [
//        'class' => UserController::class,
//        'method' => 'registrate',
//    ],
//],
//        '/login' => [
//    'GET' => [
//        'class' => UserController::class,
//        'method' => 'getLogin',
//    ],
//    'POST' => [
//        'class' => UserController::class,
//        'method' => 'login',
//    ],
//],
//        '/catalog' => [
//    'GET' => [
//        'class' => ProductController::class,
//        'method' => 'getCatalog',
//    ],
//],
//        '/edit-profile' => [
//    'GET' => [
//        'class' => UserController::class,
//        'method' => 'getEditprofile',
//    ],
//    'POST' => [
//        'class' => UserController::class,
//        'method' => 'editProfile',
//    ],
//],
//        '/profile' => [
//    'GET' => [
//        'class' => UserController::class,
//        'method' => 'profile',
//    ],
//    'POST' => [
//        'class' => UserController::class,
//        'method' => 'getProfile',
//    ],
//],
//        '/add-product' => [
//    'GET' => [
//        'class' => ProductController::class,
//        'method' => 'getaddProducts',
//    ],
//    'POST' => [
//        'class' => ProductController::class,
//        'method' => 'addProduct',
//    ],
//],
//        '/cart' => [
//    'GET' => [
//        'class' => CartController::class,
//        'method' => 'getcart',]
//],
//        '/create-order' => [
//    'GET' => [
//        'class' => OrdersController::class,
//        'method' => 'getCheckoutForm',
//    ],
//    'POST' => [
//        'class' => OrdersController::class,
//        'method' => 'handleCheckout',]
//],
//        '/user-order' => [
//    'GET' => [
//        'class' => OrdersController::class,
//        'method' => 'getAllOrders',]
//],
