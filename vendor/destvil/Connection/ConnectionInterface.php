<?php


namespace destvil\Connection;


interface ConnectionInterface {
    public function connect(ConnectionConfigInterface $connectionConfig);

    public function close();

    public function query(string $query): ResultInterface;

    public function prepare(string $value);

    public function quote(string $identifier);
}