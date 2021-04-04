<?php


namespace destvil\Routing;


class RouterConfig {
    protected array $routes;

    public function addRoute(Route $route): RouterConfig {
        $this->routes[] = $route;
        return $this;
    }

    public function getRoutes(): array {
        return $this->routes;
    }
}