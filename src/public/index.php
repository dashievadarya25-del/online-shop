<?php

use Controllers\CartController;
use Controllers\OrdersController;
use Controllers\ProductController;
use Controllers\UserController;
use Controllers\FeedbackController;

require_once './../Core/Autoloader.php';
$path = dirname(__DIR__);

\Core\Autoloader::register($path);


$app = new Core\App();
$app->get('/registration', UserController::class, 'getRegistrate');
$app->post('/registration', UserController::class, 'registrate', \Request\RegistrateRequest::class);
$app->get('/login', UserController::class, 'getLogin');
$app->post('/login', UserController::class, 'login', \Request\LoginRequest::class);
$app->get('/catalog', ProductController::class, 'getCatalog');
$app->get('/edit-profile', UserController::class, 'getEditprofile');
$app->post('/edit-profile', UserController::class, 'editProfile', \Request\EditprofileRequest::class);
$app->get('/profile', UserController::class, 'profile');
$app->get('/add-product',CartController::class, 'getaddProducts');
$app->post('/add-product', CartController::class, 'addProduct', \Request\AddProductRequest::class);
$app->get('/decrease-product', CartController::class, 'getdecreaseProducts');
$app->post('/decrease-product', CartController::class, 'decreaseProducts',\Request\DecreaseRequest::class);
$app->get('/cart', CartController::class, 'getcart');
$app->get('/create-order', OrdersController::class, 'getCheckoutForm');
$app->post('/create-order', OrdersController::class, 'handleCheckout', \Request\OrderRequest::class);
$app->get('/user-orders', OrdersController::class, 'getAllOrders');
$app->get('/feedback-product', FeedbackController::class,'getFeedbackProduct');
$app->post('/feedback-product', FeedbackController::class, 'handleFeedbackProduct', \Request\FeedbackRequest::class);


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
