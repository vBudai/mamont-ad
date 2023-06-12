<?php

namespace app\core;

use app\controllers\ErrorController;

class Router
{

    private static ?Router $instance = null;

    private array $routes;

    private function __construct() {
        $this->routes = require __DIR__."../../config/routes.php";
    }

    public static function getInstance(): Router{
        if(self::$instance === null){
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function parse(): void {
        $url = $_SERVER['REQUEST_URI'];
        $matches = null;

        $controllerName = null;
        $action = null;
        $params = array();

        foreach ($this->routes as $route){
            if (preg_match('#^' . $route['route'] . '$#', $url, $matches)) {
                $controllerName = 'app\controllers\\'.$route['controller'];
                $action = $route['action'].'_Action';

                // Парсинг параметров для метода класса-контроллера
                foreach ($matches as $param => $value){
                    if(!is_numeric($param)){
                        $params[$param] = $value;
                    }
                }

                break;
            }
        }

        if($matches == null){
            (new ErrorController())->error(404);
        }
        else{
            $controller = new $controllerName();
            $controller->$action($params);
        }
    }

    private function __clone(){}
}