<?php


namespace destvil\Routing;


use destvil\Routing\Exception\NotFoundRouteException;

class Router {
    /** @var Route[] */
    protected array $routes;

    public function __construct(RouterConfig $routerConfig) {
        $this->routes = $routerConfig->getRoutes();
    }

    public function dispatch(string $url): ?Route {
        if (strlen($url) > 1) {
            $url = rtrim($url, '/');
        }
        foreach ($this->routes as $route) {
            if ($route->getPath() !== $url) {
                continue;
            }

            return $route;
        }

        throw new NotFoundRouteException('Route not found', 404);
    }
}