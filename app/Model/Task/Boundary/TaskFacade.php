<?php


namespace app\Model\Task\Boundary;


use app\Model\Task\Boundary\Exception\TaskFacadeException;
use app\Model\Task\Control\Exception\InvalidTaskArgumentException;
use app\Model\Task\Control\TaskRepository;
use app\Model\Task\Control\TaskService;
use app\Model\Task\Control\TaskStatusRepository;
use app\Model\Task\Control\TaskTaskStatusRepository;
use app\Model\Task\Entity\Task;
use app\Model\Task\Entity\TaskNavigationFilter;
use destvil\Connection\ConnectionPool;


class TaskFacade {
    protected const STATUS_SUCCESS_CODE = 'success';
    protected const STATUS_ADMIN_EDIT_CODE = 'admin_edit';

    protected TaskRepository $taskRep;
    protected TaskStatusRepository $taskStatusRep;
    protected TaskTaskStatusRepository $taskTaskStatusRep;
    protected TaskService $taskService;

    public function __construct(
        ?TaskRepository $taskRep = null,
        ?TaskStatusRepository $taskStatusRep = null,
        ?TaskTaskStatusRepository $taskTaskStatusRep = null,
        ?TaskService $taskService = null
    ) {
        if (is_null($taskRep)) {
            $connection = ConnectionPool::getInstance()->getDefault();
            $this->taskRep = new TaskRepository($connection);
        } else {
            $this->taskRep = $taskRep;
        }

        if (is_null($taskStatusRep)) {
            $connection = ConnectionPool::getInstance()->getDefault();
            $this->taskStatusRep = new TaskStatusRepository($connection);
        } else {
            $this->taskStatusRep = $taskStatusRep;
        }

        if (is_null($taskTaskStatusRep)) {
            $connection = ConnectionPool::getInstance()->getDefault();
            $this->taskTaskStatusRep = new TaskTaskStatusRepository($connection);
        } else {
            $this->taskTaskStatusRep = $taskTaskStatusRep;
        }

        $this->taskService = $taskService ?? new TaskService();
    }

    public function createTask(array $data): bool {
        try {
            $this->taskService->checkTaskFields($data);
            return $this->taskRep->insert($data);
        } catch (InvalidTaskArgumentException $exception) {
            throw new TaskFacadeException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    public function updateTask(int $taskId, array $taskData): bool {
        try {
            $taskData = $this->taskService->checkTaskFields($taskData);
            return $this->taskRep->update($taskId, $taskData);
        } catch (InvalidTaskArgumentException $exception) {
            throw new TaskFacadeException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * Добавляет задаче статус "Выполнено"
     *
     * @param int $taskId
     * @return bool
     */
    public function markSuccessStatus(int $taskId): bool {
        return $this->addTaskStatus($taskId, self::STATUS_SUCCESS_CODE);
    }

    /**
     * Добавляет задаче статус "Редактировано администратором"
     *
     * @param int $taskId
     * @return bool
     */
    public function markAdminEditStatus(int $taskId): bool {
        return $this->addTaskStatus($taskId, self::STATUS_ADMIN_EDIT_CODE);
    }

    /**
     * Возвращает задачи и привязанные к ним статусы по навигационному фильтру
     *
     * @param TaskNavigationFilter $navigationFilter
     * @return array
     */
    public function getTaskArrayListByNavigationFilter(TaskNavigationFilter $navigationFilter): array {

        $taskList = $this->taskRep->findByNavigationFilter($navigationFilter);

        $tasksIds = array();
        foreach ($taskList as $task) {
            $tasksIds[] = $task->getId();
        }

        $statusesIds = array();

        $tasksStatusesLinking = $this->taskTaskStatusRep->findByTasksIds($tasksIds, $navigationFilter);
        foreach ($tasksStatusesLinking as $entry) {
            $statusesIds[] = $entry->getStatusId();
        }

        $taskStatuses = $this->taskStatusRep->findByIds($statusesIds);

        foreach ($tasksStatusesLinking as $taskStatusLink) {
            if (!isset($taskStatuses[$taskStatusLink->getStatusId()])) {
                continue;
            }

            $task = $taskList[$taskStatusLink->getTaskId()];
            $taskStatus = $taskStatuses[$taskStatusLink->getStatusId()];
            $taskList[$taskStatusLink->getTaskId()] =$task->withStatus($taskStatus);
        }

        $taskArrayList = array();
        foreach ($taskList as $task) {
            $taskArrayList[$task->getId()] = $this->taskRep->toArray($task);
        }

        return $taskArrayList;
    }

    public function findOneById(int $id): ?Task {
        return $this->taskRep->findOneById($id);
    }

    public function getCount(): int {
        return $this->taskRep->getCount();
    }

    protected function addTaskStatus(int $taskId, string $statusName) {
        if ($taskId <= 0) {
            return false;
        }

        $taskStatus = $this->taskStatusRep->findOneByName($statusName);
        if (!$taskStatus) {
            return false;
        }

        return $this->taskTaskStatusRep->insert(array(
            'taskId' => $taskId,
            'taskStatusId' => $taskStatus->getId()
        ));
    }
}