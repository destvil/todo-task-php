<?php


namespace app\Model\Task\Entity;


class TaskTaskStatus {
    protected int $taskId;
    protected int $statusId;

    public function __construct(int $taskId, int $statusId) {
        $this->taskId = $taskId;
        $this->statusId = $statusId;
    }

    public function getTaskId(): int {
        return $this->taskId;
    }

    public function getStatusId(): int {
        return $this->statusId;
    }
}