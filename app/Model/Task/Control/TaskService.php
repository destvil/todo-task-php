<?php


namespace app\Model\Task\Control;


use app\Model\Task\Control\Exception\InvalidTaskArgumentException;
use app\Model\Task\Control\Exception\MissingArgumentTaskException;

class TaskService {
    /**
     * Проверяет валидность полей задачи
     *
     * @param array $data
     * @return mixed
     * @throws InvalidTaskArgumentException
     * @throws MissingArgumentTaskException
     */
    public function checkTaskFields(array $data): array {
        $requiredTaskDataKeys = array(
            'userName' => 'Name',
            'email' => 'Email',
            'description' => 'Description'
        );

        $missingValues = array();
        foreach ($requiredTaskDataKeys as $key => $value) {
            if (empty($data[$key])) {
                $missingValues[] = $value;
            }
        }

        if (!empty($missingValues)) {
            throw new MissingArgumentTaskException($missingValues);
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidTaskArgumentException('Email is not corrected');
        }

        return array_intersect_key($data, $requiredTaskDataKeys);
    }
}