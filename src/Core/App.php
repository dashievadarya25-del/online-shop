<?php
namespace Core;
use Controllers\OrdersController;
use Controllers\UserController;
use Controllers\ProductController;
use Controllers\CartController;
class App
{
    private array $routes = [];
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
//                $path = "../Controllers/" . $class . ".php"; // require_once "../Controller/$class.php"
//                if (file_exists($path)) {
//                    require_once $path;
//                }
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
    public function addRoute(string $route, string $routeMethod, string $className, string $method)
    {
        $this->routes[$route][$routeMethod]= [
                'class' => $className,
                'method' => $method,
        ];
    }
}
