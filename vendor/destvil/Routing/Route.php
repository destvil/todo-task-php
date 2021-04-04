<?php


namespace destvil\Routing;


class Route {
    protected ?string $path;
    protected ?string $controller;
    protected ?string $action;

    /**
     * Route constructor.
     * @param ?string $path
     * @param ?string $controller
     * @param ?string $action
     */
    public function __construct(?string $path = null, ?string $controller = null, ?string $action = null) {
        $this->path = $path;
        $this->controller = $controller;
        $this->action = $action;
    }

    public function getPath(): string {
        return $this->path;
    }

    public function getController(): string {
        return $this->controller;
    }

    public function getAction(): string {
        return $this->action;
    }

    public function withPath(string $path): Route {
        $this->path = $path;
        return $this;
    }

    public function withController(string $controller): Route {
        $this->controller = $controller;
        return $this;
    }

    public function withAction(string $action): Route {
        $this->action = $action;
        return $this;
    }
}