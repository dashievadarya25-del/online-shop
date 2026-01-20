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

        if (isset($this->routes[$requestUri])) {
            $routeMethods = $this->routes[$requestUri];

            if (isset($routeMethods[$requestMethod])) {
                $handler = $routeMethods[$requestMethod];

//        $handler = [
//            'class' => 'UserController',
//            'method' => 'getRegistrate',
//        ];
                $class = $handler['class'];
                $method = $handler['method'];
                $path = "../Controllers/" . $class . ".php"; // require_once "../Controller/$class.php"
                if (file_exists($path)) {
                    require_once $path;
                }
                $controller = new $class();
                $controller->$method();
            } else {
                echo "$requestMethod не поддерживается для $requestUri";
            }
        } else {
            http_response_code(404);
            require_once '../Views/404.php';
        }

    }

}
