<?php


namespace app\Model\Task\Control;


use app\Model\Task\Entity\TaskNavigationFilter;
use app\Model\Task\Entity\TaskTaskStatus;
use destvil\Connection\ConnectionInterface;
use destvil\Connection\SelectResultInterface;


class TaskTaskStatusRepository {
    public const TABLE_NAME = 'd_task_task_status';

    protected ConnectionInterface $connection;

    public function __construct(ConnectionInterface $connection) {
        $this->connection = $connection;
    }

    /**
     * @param array $tasksIds
     * @param TaskNavigationFilter|null $navigationFilter
     * @return TaskTaskStatus[]
     */
    public function findByTasksIds(array $tasksIds, ?TaskNavigationFilter $navigationFilter = null): array {
        $tasksStatusesLinking = array();
        if (empty($tasksIds)) {
            return $tasksStatusesLinking;
        }

        $tasksIdsStr = implode(', ', $tasksIds);

        $orderByExpr = '';
        if ($navigationFilter && in_array($navigationFilter->getOrderField(), array('taskId', 'taskStatusId'))) {
            $orderByExpr = sprintf(
                ' ORDER BY %s %s',
                $this->connection->quote($navigationFilter->getOrderField()),
                $navigationFilter->getOrderValue()
            );
        }

        $query = sprintf(
            'SELECT %s, %s FROM %s WHERE %s IN (%s)%s',
            $this->connection->quote('taskId'),
            $this->connection->quote('taskStatusId'),
            $this->connection->quote(self::TABLE_NAME),
            $this->connection->quote('taskId'),
            $this->connection->prepare($tasksIdsStr),
            $orderByExpr
        );

        /** @var SelectResultInterface $dbResult */
        $dbResult = $this->connection->query($query);
        while ($item = $dbResult->fetch()) {
            $tasksStatusesLinking[] = $this->fromArray($item);
        }

        return $tasksStatusesLinking;
    }

    public function insert(array $data): bool {
        $query = sprintf(
            'INSERT INTO %s (%s, %s) VALUES ("%s", "%s")',
            $this->connection->quote(self::TABLE_NAME),
            $this->connection->quote('taskId'),
            $this->connection->quote('taskStatusId'),
            $this->connection->prepare($data['taskId']),
            $this->connection->prepare($data['taskStatusId'])
        );

        $dbResult = $this->connection->query($query);
        return $dbResult->isSuccess();
    }

    public function fromArray(array $data): TaskTaskStatus {
        return new TaskTaskStatus(
            $data['taskId'],
            $data['taskStatusId']
        );
    }
}