<?php


namespace app\Model\Task\Control\Exception;


class MissingArgumentTaskException extends InvalidTaskArgumentException {
    public function __construct($missingValuesKeys) {
        if (!is_array($missingValuesKeys)) {
            $missingValuesKeys = array($missingValuesKeys);
        }

        $missingValuesKeys = array_map(static function ($key) {
            $key = trim($key, '"\'');
            return '"' .$key . '"';
        }, $missingValuesKeys);
        $errorMessage = 'The following fields are not filled: ' . implode(', ', $missingValuesKeys);
        parent::__construct($errorMessage);
    }
}