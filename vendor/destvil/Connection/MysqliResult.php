<?php


namespace destvil\Connection;


class MysqliResult implements ResultInterface {
    protected bool $operationStatus;

    public function __construct($operationStatus) {
        $this->operationStatus = $operationStatus;
    }

    public function isSuccess(): bool {
        return $this->operationStatus;
    }
}