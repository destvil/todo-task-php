<?php


namespace destvil\Connection;


interface SelectResultInterface extends ResultInterface {
    public function fetch(): ?array;

    public function getAffectedNumRows(): int;
}