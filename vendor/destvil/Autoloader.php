<?php


namespace destvil;


class Autoloader {
    protected array $registeredPrefix;

    public function __construct() {
        $this->registeredPrefix = array();
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
                $_SERVER['DOCUMENT_ROOT'],
                $prefix,
                $class
            );
            if (is_readable($classPath)) {
                include $classPath;
                return;
            }
        }

        $classPath = sprintf('%s' . DIRECTORY_SEPARATOR . '%s.php', $_SERVER['DOCUMENT_ROOT'], $class);
        if (is_readable($classPath)) {
            include $classPath;
            return;
        }
    }
}