<?php


namespace destvil\Connection;


class MysqliConnectionConfig implements ConnectionConfigInterface {
    protected string $host;
    protected string $userName;
    protected string $password;
    protected string $dbName;

    /**
     * ConnectionConfig constructor.
     * @param string $host
     * @param string $userName
     * @param string $password
     * @param string $dbName
     */
    public function __construct(string $host, string $userName, string $password, string $dbName) {
        $this->host = $host;
        $this->userName = $userName;
        $this->password = $password;
        $this->dbName = $dbName;
    }

    public function getHost(): string {
        return $this->host;
    }

    public function getUserName(): string {
        return $this->userName;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function getDbName(): string {
        return $this->dbName;
    }
}