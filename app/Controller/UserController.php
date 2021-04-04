<?php


namespace app\Controller;


use app\Model\User\Boundary\UserFacade;
use destvil\Core\Controller;
use destvil\Core\Exception;
use destvil\Core\SessionManager;
use destvil\Core\View;


class UserController extends Controller {
    public function login(): void {
        $viewData = array('title' => 'Авторизация');

        $userFacade = new UserFacade();
        if ($userFacade->isAuthorized()) {
            header('Location: /');
        }

        $sessionManager = new SessionManager();
        if ($this->request->hasPost('auth')) {
            try {
                if (!$sessionManager->verifyToken($this->request->getPost('token'))) {
                    throw new Exception('Произошла ошибка');
                }

                $login = $this->request->getPost('login');
                $password = $this->request->getPost('password');
                if (empty($login) || empty($password)) {
                    throw new Exception('Произошла ошибка');
                }

                if ($userFacade->login($login, $password)) {
                    header('Location: /');
                    exit();
                }

                throw new Exception('Не верный логин или пароль');
            } catch (Exception $exception) {
                $viewData['error'] = $exception->getMessage();
            }
        }

        (new View())->render('/public/pages/user/login.php', $viewData);
    }

    public function logout(): void {
        $userFacade = new UserFacade();
        $userFacade->logout();

        header('Location: /');
    }
}