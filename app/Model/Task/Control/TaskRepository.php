<?php


namespace app\Model\Task\Control;


use app\Model\Task\Entity\Task;
use app\Model\Task\Entity\TaskNavigationFilter;
use ArrayIterator;
use destvil\Connection\ConnectionInterface;
use destvil\Connection\MysqliSelectResult;

class TaskRepository {
    public const TABLE_NAME = 'd_task';

    protected ConnectionInterface $connection;

    public function __construct(ConnectionInterface $connection) {
        $this->connection = $connection;
    }

    public function insert(array $data): bool {
        $query = sprintf(
            'INSERT INTO %s (%s, %s, %s) VALUES ("%s", "%s", "%s")',
            $this->connection->quote(self::TABLE_NAME),
            $this->connection->quote('userName'),
            $this->connection->quote('email'),
            $this->connection->quote('description'),
            $this->connection->prepare($data['userName']),
            $this->connection->prepare($data['email']),
            $this->connection->prepare($data['description'])
        );

        $dbResult = $this->connection->query($query);
        return $dbResult->isSuccess();
    }

    public function update(int $taskId, array $taskData): bool {
        $updateCondition = '';

        $taskDataIterator = new ArrayIterator($taskData);
        while ($taskDataIterator->valid()) {
            $taskFieldValue = $taskDataIterator->current();
            $taskFieldValue = trim($taskFieldValue);

            $quoteTaskKey = $this->connection->quote($taskDataIterator->key());

            $quoteTaskValue = $this->connection->prepare($taskFieldValue);

            $updateCondition .= $quoteTaskKey . ' = "' . $quoteTaskValue . '"';

            $taskDataIterator->next();
            if ($taskDataIterator->valid()) {
                $updateCondition .= ', ';
            }
        }

        $query = sprintf(
            'UPDATE %s SET %s WHERE %s = %s',
            $this->connection->quote(self::TABLE_NAME),
            $updateCondition,
            $this->connection->quote('id'),
            $this->connection->prepare($taskId)
        );

        $dbResult = $this->connection->query($query);
        return $dbResult->isSuccess();
    }

    public function findOneById(int $taskId): ?Task {
        $query = sprintf(
            'SELECT %s, %s, %s, %s FROM %s WHERE %s = "%s"',
            $this->connection->quote('id'),
            $this->connection->quote('userName'),
            $this->connection->quote('email'),
            $this->connection->quote('description'),
            $this->connection->quote(self::TABLE_NAME),
            $this->connection->quote('id'),
            $this->connection->prepare($taskId),
        );

        $dbResult = $this->connection->query($query);
        if ($taskItem = $dbResult->fetch()) {
            return $this->fromArray($taskItem);
        }

        return null;
    }

    /**
     * @param TaskNavigationFilter $navigationFilter
     * @return Task[]
     */
    public function findByNavigationFilter(TaskNavigationFilter $navigationFilter): array {
        $tasks = array();

        $orderByCondition = '';
        if (in_array($navigationFilter->getOrderField(), array('userName', 'email', 'taskStatusCount'))) {
            $orderByCondition = sprintf(
                ' ORDER BY %s %s ',
                $this->connection->quote($navigationFilter->getOrderField()),
                $navigationFilter->getOrderValue()
            );
        }

        $query = sprintf(
            'SELECT %s, %s, %s, %s, COUNT(%s) as %s FROM %s LEFT JOIN %s ON %s = %s GROUP BY %s%s LIMIT %s OFFSET %s',
            $this->connection->quote('id'),
            $this->connection->quote('userName'),
            $this->connection->quote('email'),
            $this->connection->quote('description'),
            $this->connection->quote('taskId'),
            $this->connection->quote('taskStatusCount'),
            $this->connection->quote(self::TABLE_NAME),
            $this->connection->quote(TaskTaskStatusRepository::TABLE_NAME),
            $this->connection->quote(self::TABLE_NAME) . '.' . $this->connection->quote('id'),
            $this->connection->quote(TaskTaskStatusRepository::TABLE_NAME) . '.' . $this->connection->quote('taskId'),
            $this->connection->quote('id'),
            $orderByCondition,
            $this->connection->prepare($navigationFilter->getLimit()),
            $this->connection->prepare($navigationFilter->getOffset())
        );

        $dbResult = $this->connection->query($query);
        while ($taskData = $dbResult->fetch()) {
            $task = $this->fromArray($taskData);
            $tasks[$task->getId()] = $task;
        }

        return $tasks;
    }

    public function getCount(): int {
        $query = sprintf(
            'SELECT COUNT(*) AS %s FROM %s',
            $this->connection->quote('count'),
            $this->connection->quote(self::TABLE_NAME)
        );

        /** @var MysqliSelectResult $dbResult */
        $dbResult = $this->connection->query($query);

        $fetchRow = $dbResult->fetch();
        return is_null($fetchRow) ? 0 : $fetchRow['count'];
    }

    public function fromArray(array $data): Task {
        return new Task(
            $data['id'],
            $data['userName'],
            $data['email'],
            $data['description']
        );
    }

    public function toArray(Task $task): array {
        $taskStatuses = $task->getStatuses();

        $taskStatusesArray = array();
        foreach($taskStatuses as $status) {
            $taskStatusesArray[$status->getName()] = array(
                'id' => $status->getId(),
                'name' => $status->getName(),
                'value' => $status->getValue()
            );
        }

        return array(
            'id' => $task->getId(),
            'userName' => $task->getUserName(),
            'email' => $task->getEmail(),
            'description' => $task->getDescription(),
            'statuses' => $taskStatusesArray
        );
    }
}