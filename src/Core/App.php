<?php

class App
{
    private array $routes = [
        '/registration' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'getRegistrate',
            ],
            'POST' => [
                'class' => 'UserController',
                'method' => 'registrate',
            ],
        ],
        '/login' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'getLogin',
            ],
            'POST' => [
                'class' => 'UserController',
                'method' => 'login',
            ],
        ],
        '/catalog' => [
            'GET' => [
                'class' => 'ProductController',
                'method' => 'getCatalog',
            ],
        ],
        '/edit-profile' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'getEditprofile',
            ],
            'POST' => [
                'class' => 'UserController',
                'method' => 'editProfile',
            ],
        ],
        '/profile' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'profile',
            ],
            'POST' => [
                'class' => 'UserController',
                'method' => 'getProfile',
            ],
        ],
        '/add-product' => [
            'GET' => [
                'class' => 'ProductController',
                'method' => 'getaddProducts',
            ],
            'POST' => [
                'class' => 'ProductController',
                'method' => 'addProduct',
            ],
        ],
        '/cart' => [
            'GET' => [
                'class' => 'CartController',
                'method' => 'getcart',]
        ],
    ];
    public function run()
    {
        $requestUri = $_SERVER['REQUEST_URI']; // /registration
        $requestMethod = $_SERVER['REQUEST_METHOD']; // GET

        $routeMethods = $this->routes[$requestUri];

//        $routeMethods = [
//            'GET' => [
//                'class' => 'UserController',
//                'method' => 'getRegistrate',
//            ],
//            'POST' => [
//                'class' => 'UserController',
//                'method' => 'registrate',
//            ],
//        ];

        $handler = $routeMethods[$requestMethod];

//        $handler = [
//            'class' => 'UserController',
//            'method' => 'getRegistrate',
//        ];
        $class = $handler['class'];
        $method = $handler['method'];
        $path = "../Controllers/" . $class . ".php";
        if (file_exists($path)) {
            require_once $path;
        }
        $controller = new $class();
        $controller->$method();
    }

}
//$path = "../Controllers/" . $className . ".php";
//    if (file_exists($path)) {
//        require_once $path;