<?php
namespace App\Services;

class Route
{
    private static $routes = [];
    private static $controllerNamespace = 'App\Controllers\\';
    public static function add($uri, $controller, $action, $method = 'GET', $middleware = [])
    {
        $position = strpos($uri, '/{');
        if ($position !== false) {
            $prefix = substr($uri, 0, $position);
        } else {
            $prefix = $uri;
        }
        preg_match_all('/\{(\w+)\}/', $uri, $matches);

        self::$routes[] = [
            'method' => $method,
            'uri' => $prefix,
            'params' => $matches[1],
            'controller' => $controller,
            'action' => $action,
            'middleware' => $middleware
        ];
    }
    public static function get($uri, $controller, $action, $middleware = [])
    {
        self::add($uri, $controller, $action, 'GET', $middleware);
    }
    public static function post($uri, $controller, $action, $middleware = [])
    {
        self::add($uri, $controller, $action, 'POST', $middleware);
    }
    public static function handle()
    {
        $requestURI = $_SERVER['REQUEST_URI'];//get uri like /some/some?id=4&name=name
        $uriComponents = parse_url($requestURI);//get only uri like /some/some
        $path = $uriComponents['path'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        foreach (self::$routes as $route) {
            if ('/' . $route['uri'] === $path && $route['method'] === $requestMethod) {

                $parameter = [];
                foreach ($route['params'] as $params) {
                    if (isset($_GET[$params])) {
                        $parameter[$params] = $_GET[$params];
                    } else {
                        echo 'parameters not matched';
                        exit();
                    }
                }
                //handle middleware
             foreach ($route['middleware'] as $middleware) {
                if (is_array($middleware)) {
                    // [Class, param1, param2, ...]
                    $middlewareClass = new $middleware[0]();
                    $args = array_slice($middleware, 1);
                    $middlewareClass->handle(...$args);
                } else {
                    $middlewareClass = new $middleware();
                    $middlewareClass->handle();
                }
            }

                $controllerClass = self::$controllerNamespace . $route['controller'];
                $action = $route['action'];
                $controller = new $controllerClass();
                $controller->$action(...$parameter);
                return;
            }
        }
        view('components.404');
    }
}