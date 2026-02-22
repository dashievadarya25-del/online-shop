<?php

use Controllers\CartController;
use Controllers\OrdersController;
use Controllers\ProductController;
use Controllers\UserController;

require_once './../Core/Autoloader.php';
$path = dirname(__DIR__);

\Core\Autoloader::register($path);


$app = new Core\App();
$app->get('/registration', UserController::class, 'getRegistrate');
$app->post('/registration', UserController::class, 'registrate');
$app->addRoute('/login', 'GET', UserController::class, 'getLogin');
$app->addRoute('/login', 'POST', UserController::class, 'login');
$app->addRoute('/catalog', 'GET', ProductController::class, 'getCatalog');
$app->addRoute('/edit-profile', 'GET', UserController::class, 'getEditprofile');
$app->addRoute('/edit-profile', 'POST', UserController::class, 'editProfile');
$app->addRoute('/profile', 'GET', UserController::class, 'profile');
$app->addRoute('/add-product', 'GET', ProductController::class, 'getaddProducts');
$app->addRoute('/add-product', 'POST', ProductController::class, 'addProduct');
$app->get('/decrease-product', ProductController::class, 'getdecreaseProducts');
$app->post('/decrease-product', ProductController::class, 'decreaseProducts');
$app->addRoute('/cart', 'GET', CartController::class, 'getcart');
$app->addRoute('/create-order', 'GET', OrdersController::class, 'getCheckoutForm');
$app->addRoute('/create-order', 'POST', OrdersController::class, 'handleCheckout');
$app->addRoute('/user-order', 'GET', OrdersController::class, 'getAllOrders');
$app->get('/feedback', ProductController::class, 'getFeedback');
$app->post('/feedback', ProductController::class, 'handleFeedback');


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
