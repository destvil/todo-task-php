<?php


namespace destvil\Connection;


interface ConnectionConfigInterface {
    public function getHost();

    public function getUserName();

    public function getPassword();

    public function getDbName();
}