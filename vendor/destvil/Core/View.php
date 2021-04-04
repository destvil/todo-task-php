<?php


namespace destvil\Core;


class View {
    public function render(string $templatePath, array $data = array()): void {
        $data = array_merge($this->getUserData(), $data);

        $templatePath = trim($templatePath, '/');
        $path = Application::getInstance()->getDocumentRoot() . DIRECTORY_SEPARATOR . $templatePath;
        if (!is_readable($path)) {
            throw new \Exception('Template not found');
        }

        include $path;
    }

    public function getUserData(): array {
        $sessionManager = new SessionManager();
        $userData = array(
            'token' => $sessionManager->getToken(),
            'isAuthorize' => $sessionManager->get('isAuthorize'),
            'notify' => $sessionManager->get('notify')
        );

        $sessionManager->delete('notify');
        return $userData;
    }
}