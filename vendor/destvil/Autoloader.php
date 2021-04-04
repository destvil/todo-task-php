<?php


namespace destvil;


class Autoloader {
    protected string $documentRoot;
    protected array $registeredPrefix;

    public function __construct(?string $documentRoot = null) {
        $this->registeredPrefix = array();

        $this->documentRoot = $documentRoot ?? $_SERVER['DOCUMENT_ROOT'];
    }

    public function registerPrefix(string $prefix): Autoloader {
        $this->registeredPrefix[] = $prefix;
        return $this;
    }

    public function register(): void {
        spl_autoload_register(array($this, 'loader'));
    }

    private function loader(string $className): void {
        $class = str_replace('\\', DIRECTORY_SEPARATOR, trim($className));
        foreach ($this->registeredPrefix as $prefix) {
            $prefix = str_replace('\\', DIRECTORY_SEPARATOR, trim($prefix));
            $classPath = sprintf(
                '%s' . DIRECTORY_SEPARATOR . '%s' . DIRECTORY_SEPARATOR . '%s.php',
                $this->documentRoot,
                $prefix,
                $class
            );
            if (is_readable($classPath)) {
                include $classPath;
                return;
            }
        }

        $classPath = sprintf('%s' . DIRECTORY_SEPARATOR . '%s.php', $this->documentRoot, $class);
        if (is_readable($classPath)) {
            include $classPath;
            return;
        }
    }
}