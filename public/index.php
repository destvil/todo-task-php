<?php
/**
 * Used php 7.4
 */

use destvil\Autoloader;
use destvil\Connection\ConnectionPool;
use destvil\Connection\Exception\SqlConnectException;
use destvil\Connection\MysqliConnection;
use destvil\Connection\MysqliConnectionConfig;
use destvil\Core\Application;
use destvil\Core\ControllerManager;
use destvil\Core\Request;
use destvil\Core\SessionManager;
use destvil\Routing\Exception\NotFoundRouteException;
use destvil\Routing\Router;
use destvil\Routing\RouterConfig;

error_reporting(E_ERROR);
ini_set('display_errors', 'On');

include dirname(__DIR__) . '/vendor/autoloader.php';

$autoloader = new Autoloader(dirname(__DIR__));

$autoloader->register();
$autoloader->registerPrefix('app');
$autoloader->registerPrefix('vendor');

$application = Application::getInstance();
$application->setDocumentRoot(dirname(__DIR__));

$request = new Request();
$sessionManager = new SessionManager();

$sessionManager->start();

if (!$sessionManager->has('token')) {
    $sessionManager->set('token', $request->generateCSRFToken());
}

$connectionData = include $application->getDocumentRoot() . '/config/database.php';
$connectionConfig = new MysqliConnectionConfig(
    $connectionData['host'],
    $connectionData['login'],
    $connectionData['password'],
    $connectionData['database']
);

$connection = new MysqliConnection();
$connection->connect($connectionConfig);
$connectionPool = ConnectionPool::getInstance();
$connectionPool->setDefault($connection);

$controllerManager = new ControllerManager();
$routerConfig = new RouterConfig();

/** @var Closure $callback */
$routesCallback = include $application->getDocumentRoot() . '/config/routes.php';
$routesCallback($routerConfig);
$router = new Router($routerConfig);
try {
    $urlWithoutQuery = $request->getUrlWithoutQuery();

    $route = $router->dispatch($urlWithoutQuery);
    $controller = $controllerManager->getControllerByRoute($route);
} catch (NotFoundRouteException $exception) {
    $controller = $controllerManager->get404Controller($exception);
}

$controller->execute();
$connection->close();
