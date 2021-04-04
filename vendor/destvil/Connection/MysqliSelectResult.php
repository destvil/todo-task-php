<?php


namespace destvil\Connection;


class MysqliSelectResult extends MysqliResult implements SelectResultInterface {
    protected \mysqli_result $result;

    public function __construct(\mysqli_result $result) {
        $this->result = $result;
        parent::__construct($this->getAffectedNumRows());
    }

    public function fetch(): ?array {
        return $this->result->fetch_assoc();
    }

    public function getAffectedNumRows(): int {
        return $this->result->num_rows;
    }
}