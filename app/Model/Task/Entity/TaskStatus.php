<?php


namespace app\Model\Task\Entity;


class TaskStatus {
    protected int $id;
    protected string $name;
    protected string $value;

    public function __construct(int $id, string $name, string $value) {
        $this->id = $id;
        $this->name = $name;
        $this->value = $value;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getValue(): string {
        return $this->value;
    }
}