<?php


namespace destvil\Core;


use ReflectionMethod;

abstract class Controller {
    protected Request $request;
    protected string $action;

    public function __construct(string $action = 'index') {
        $this->request = new Request();
        $this->action = $action;
    }

    public function execute() {
        $reflectionMethod = new ReflectionMethod($this, $this->action);
        return $reflectionMethod->invoke($this);
    }
}