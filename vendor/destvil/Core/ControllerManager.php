<?php


namespace destvil\Core;


use app\Controller\ExceptionController;
use destvil\Routing\Route;

class ControllerManager {
    public function getControllerByRoute(Route $route): Controller {
        $reflectionClass = new \ReflectionClass($route->getController());
        if (!$reflectionClass->isSubclassOf(Controller::class)) {
            throw new \Exception('ne nado tak');
        }

        if (!$reflectionClass->hasMethod($route->getAction())) {
            throw new \Exception('method not found');
        }

        $reflectionMethod = new \ReflectionMethod($route->getController(), $route->getAction());
        if (!$reflectionMethod->isPublic()) {
            throw new \Exception('method is not public');
        }

        return $reflectionClass->newInstance($route->getAction());
    }

    public function get404Controller(Exception $exception): Controller {
        return new ExceptionController($exception, 'error404');
    }
}