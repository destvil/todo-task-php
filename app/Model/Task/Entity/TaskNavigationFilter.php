<?php


namespace app\Model\Task\Entity;


class TaskNavigationFilter {
    protected int $limit;
    protected int $offset;
    protected ?string $orderField;
    protected ?string $orderValue;

    public function __construct(int $limit, int $offset, ?string $orderField = null, ?string $orderValue = null) {
        $this->limit = $limit;
        $this->offset = $offset;
        $this->orderField = $orderField;

        if (!empty($orderValue)) {
            $this->orderValue = strtolower($orderValue) === 'asc' ? 'asc' : 'desc';
        } else {
            $this->orderValue = $orderValue;
        }
    }

    public function getLimit(): int {
        return $this->limit;
    }

    public function getOffset(): int {
        return $this->offset;
    }

    public function getOrderField(): ?string {
        return $this->orderField;
    }

    public function getOrderValue(): ?string {
        return $this->orderValue;
    }
}