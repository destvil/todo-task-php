<?php


namespace destvil\Core;


class Application {
    protected static ?self $instance = null;
    protected ?string $rootPath = null;

    protected function __construct() {}

    public static function getInstance(): self {
        if (!self::$instance) {
            self::$instance = new Application();
        }

        return self::$instance;
    }

    public function getDocumentRoot(): string {
        if (!$this->rootPath) {
            return $_SERVER['DOCUMENT_ROOT'];
        }

        return $this->rootPath;
    }

    public function setDocumentRoot(string $path): void {
        $this->rootPath = $path;
    }
}