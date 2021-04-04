<?php


namespace app\Model\Task\Control;


use app\Model\Task\Entity\TaskStatus;
use destvil\Connection\ConnectionInterface;
use destvil\Connection\SelectResultInterface;


class TaskStatusRepository {
    public const TABLE_NAME = 'd_task_status';

    protected ConnectionInterface $connection;

    public function __construct(ConnectionInterface $connection) {
        $this->connection = $connection;
    }

    public function findOneByName(string $name): ?TaskStatus {
        if (empty($name)) {
            return null;
        }

        $query = sprintf(
            'SELECT %s, %s, %s FROM %s WHERE %s = "%s"',
            $this->connection->quote('id'),
            $this->connection->quote('name'),
            $this->connection->quote('value'),
            $this->connection->quote(self::TABLE_NAME),
            $this->connection->quote('name'),
            $this->connection->prepare($name)
        );

        /** @var SelectResultInterface $dbResult */
        $dbResult = $this->connection->query($query);
        if ($item = $dbResult->fetch()) {
            return $this->fromArray($item);
        }

        return null;
    }

    /**
     * @param int[] $taskStatusesIds
     * @return TaskStatus[]
     */
    public function findByIds(array $taskStatusesIds): array {
        $tasksStatuses = array();
        if (empty($taskStatusesIds)) {
            return $tasksStatuses;
        }

        $preparedTaskStatusesIds = array();
        foreach ($taskStatusesIds as $statusId) {
            $statusId = trim($statusId, '"\'');
            $preparedTaskStatusesIds[] = '"' . $this->connection->prepare($statusId) . '"';
        }

        $whereInCondition = implode(', ', $preparedTaskStatusesIds);

        $query = sprintf(
            'SELECT %s, %s, %s FROM %s WHERE %s IN(%s)',
            $this->connection->quote('id'),
            $this->connection->quote('name'),
            $this->connection->quote('value'),
            $this->connection->quote(self::TABLE_NAME),
            $this->connection->quote('id'),
            $whereInCondition
        );

        /** @var SelectResultInterface $dbResult*/
        $dbResult = $this->connection->query($query);
        while ($item = $dbResult->fetch()) {
            $taskStatus = $this->fromArray($item);
            $tasksStatuses[$taskStatus->getId()] = $taskStatus;
        }

        return $tasksStatuses;
    }

    public function fromArray(array $data): TaskStatus {
        return new TaskStatus(
            $data['id'],
            $data['name'],
            $data['value']
        );
    }
}