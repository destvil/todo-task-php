<?php


namespace app\Model\Task\Entity;


class Task {
    protected int $id;
    protected string $userName;
    protected string $email;
    protected string $description;
    protected array $statuses;

    public function __construct(int $id, string $userName, string $email, string $description) {
        $this->id = $id;
        $this->userName = $userName;
        $this->email = $email;
        $this->description = $description;
        $this->statuses = array();
    }

    public function getId(): int {
        return $this->id;
    }

    public function getUserName(): string {
        return $this->userName;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function withStatus(TaskStatus $taskStatus): self {
        $instance = clone $this;
        $instance->statuses[] = $taskStatus;
        return $instance;
    }

    /** @return TaskStatus[] */
    public function getStatuses(): array {
        return $this->statuses;
    }
}