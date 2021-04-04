<?php


namespace destvil\Connection;


class ConnectionPool {
    protected static ?ConnectionPool $instance = null;

    protected ConnectionInterface $defaultConnection;

    private function __construct() {}

    public static function getInstance(): self {
        if (self::$instance) {
            return self::$instance;
        }

        return self::$instance = new self();
    }

    public function getDefault(): ?ConnectionInterface {
        return $this->defaultConnection;
    }

    public function setDefault(ConnectionInterface $connection): void {
        $this->defaultConnection = $connection;
    }
}