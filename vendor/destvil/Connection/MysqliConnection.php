<?php


namespace destvil\Connection;


use destvil\Connection\Exception\SqlConnectException;
use destvil\Connection\Exception\SqlQueryException;
use Mysqli;


class MysqliConnection implements ConnectionInterface {
    protected Mysqli $connection;

    public function connect(ConnectionConfigInterface $connectionConfig) {
        $this->connection = new Mysqli(
            $connectionConfig->getHost(),
            $connectionConfig->getUserName(),
            $connectionConfig->getPassword(),
            $connectionConfig->getDbName()
        );

        if ($this->connection->connect_errno) {
            throw new SqlConnectException($this->connection->connect_error, $this->connection->connect_errno);
        }
    }

    public function close(): void {
        $this->connection->close();
    }

    public function query(string $query): ResultInterface {
        $result = $this->connection->query($query);
        if ($this->connection->connect_errno) {
            throw new SqlQueryException($this->connection->connect_error, $this->connection->connect_errno);
        }

        return ($result instanceof \mysqli_result) ? new MysqliSelectResult($result) : new MysqliResult($result);
    }

    public function prepare(string $value): string {
        $escaped = $this->connection->escape_string($value);
        if ($this->connection->connect_errno) {
            throw new SqlQueryException($this->connection->connect_error, $this->connection->connect_errno);
        }

        return $escaped;
    }

    public function quote(string $identifier): string {
        $identifier = trim($identifier);
        return '`' . $identifier . '`';
    }
}