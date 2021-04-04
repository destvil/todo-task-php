<?php


namespace app\Controller;


use destvil\Core\Controller;
use destvil\Core\Exception;
use destvil\Core\View;


class ExceptionController extends Controller {
    protected Exception $exception;

    public function __construct(Exception $exception, string $action) {
        $this->exception = $exception;
        parent::__construct($action);
    }

    public function error404(): void {
        (new View())->render('/public/pages/error/404.php');
    }
}