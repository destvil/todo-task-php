<?php

use destvil\Routing\Route;
use destvil\Routing\RouterConfig;

return static function (RouterConfig $routerConfig) {
    $routerConfig->addRoute(
        (new Route())
            ->withPath('/')
            ->withController(\app\Controller\TaskController::class)
            ->withAction('list'),
    );

    $routerConfig->addRoute(
        (new Route())
            ->withPath('/create')
            ->withController(\app\Controller\TaskController::class)
            ->withAction('create')
    );

    $routerConfig->addRoute((new Route())
        ->withPath('/edit')
        ->withController(\app\Controller\TaskController::class)
        ->withAction('edit')
    );

    $routerConfig->addRoute((new Route())
        ->withPath('/login')
        ->withController(\app\Controller\UserController::class)
        ->withAction('login')
    );

    $routerConfig->addRoute((new Route())
        ->withPath('/logout')
        ->withController(\app\Controller\UserController::class)
        ->withAction('logout')
    );

    $routerConfig->addRoute((new Route())
        ->withPath('/task/success')
        ->withController(\app\Controller\TaskController::class)
        ->withAction('success')
    );
};