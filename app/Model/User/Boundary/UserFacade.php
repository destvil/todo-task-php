<?php


namespace app\Model\User\Boundary;


use app\Model\User\Control\UserRepository;
use destvil\Connection\ConnectionPool;
use destvil\Core\SessionManager;


class UserFacade {
    protected const AUTHORIZE_KEY = 'isAuthorize';

    protected UserRepository $userRep;
    protected SessionManager $sessionManager;

    public function __construct(?UserRepository $userRep = null, ?SessionManager $sessionManager = null) {
        if (is_null($userRep)) {
            $connection = ConnectionPool::getInstance()->getDefault();
            $this->userRep = new UserRepository($connection);
        } else {
            $this->userRep = $userRep;
        }

        if (is_null($sessionManager)) {
            $this->sessionManager = new SessionManager();
        } else {
            $this->sessionManager = $sessionManager;
        }
    }

    public function isAuthorized(): bool {
        return (bool) $this->sessionManager->get(self::AUTHORIZE_KEY);
    }

    public function login(string $login, string $password): bool {
        if ($this->isAuthorized()) {
            return true;
        }

        if (empty($login) || empty($password)) {
            return false;
        }

        $user = $this->userRep->findOneByLogin($login);
        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user->getPassword())) {
            return false;
        }

        $this->sessionManager->set(self::AUTHORIZE_KEY, true);
        return true;
    }

    public function logout(): void {
        $this->sessionManager->delete(self::AUTHORIZE_KEY);
    }
}