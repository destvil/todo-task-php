<?php


namespace app\Model\User\Control;


use app\Model\User\Entity\User;
use destvil\Connection\ConnectionInterface;

class UserRepository {
    public const TABLE_NAME = 'd_user';

    protected ConnectionInterface $connection;

    public function __construct(ConnectionInterface $connection) {
        $this->connection = $connection;
    }

    public function findOneByLogin(string $login): ?User {
        $query = sprintf(
            'SELECT %s, %s, %s FROM %s WHERE %s = "%s"',
            $this->connection->quote('id'),
            $this->connection->quote('login'),
            $this->connection->quote('password'),
            $this->connection->quote(self::TABLE_NAME),
            $this->connection->quote('login'),
            $this->connection->prepare($login)
        );

        $dbResult = $this->connection->query($query);
        $userData = $dbResult->fetch();
        if (!$userData) {
            return null;
        }
        return $this->fromArray($userData);
    }

    public function fromArray(array $data): User {
        return new User(
            $data['id'],
            $data['login'],
            $data['password']
        );
    }
}