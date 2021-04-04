<?php


namespace app\Controller;


use app\Model\Task\Boundary\Exception\TaskFacadeException;
use app\Model\Task\Boundary\TaskFacade;
use app\Model\Task\Entity\TaskNavigationFilter;
use app\Model\User\Boundary\UserFacade;
use destvil\Core\Controller;
use destvil\Core\SessionManager;
use destvil\Core\View;


class TaskController extends Controller {
    protected const TASK_LIST_COUNT = 3;

    public function list(): void {
        $taskFacade = new TaskFacade();

        $currPageNum = $this->request->getGet('page') ?? 1;
        if ($currPageNum < 1) {
            $currPageNum = 1;
        }

        $offset = ($currPageNum - 1) * self::TASK_LIST_COUNT;

        $orderField = $this->request->getGet('sort');
        $orderValue = $this->request->getGet('order');

        if (!empty($orderField) && !empty($orderValue)) {
            $orderValue = strtolower($orderValue) === 'asc' ? 'asc' : 'desc';
        }

        $taskNavigationFilter = new TaskNavigationFilter(
            self::TASK_LIST_COUNT,
            $offset,
            $orderField,
            $orderValue
        );

        $tasksList = $taskFacade->getTaskArrayListByNavigationFilter($taskNavigationFilter);

        $tasksCount = $taskFacade->getCount();
        $lastPageNum = (int) ceil($tasksCount / self::TASK_LIST_COUNT);

        $viewData = array(
            'title' => 'Task list',
            'tasks' => $tasksList,
            'tasksCount' => $tasksCount,
            'tasksCountInPage' => self::TASK_LIST_COUNT,
            'currPageNum' => $currPageNum,
            'lastPageNum' => $lastPageNum,
            'orderField' => $orderField,
            'orderValue' => $orderValue,
            'sortFields' => array(
                'userName' => 'Name',
                'email' => 'Email',
                'taskStatusCount' => 'Status'
            )
        );

        (new View())->render('/public/pages/task/list.php', $viewData);
    }

    public function create(): void {
        $viewData = array('title' => 'Create task');

        if ($this->request->hasPost('create')) {
            $taskData = array(
                'userName' => trim($this->request->getPost('userName')),
                'email' => trim($this->request->getPost('email')),
                'description' => trim($this->request->getPost('description'))
            );

            $taskFacade = new TaskFacade();
            try {
                $taskCreateResult = $taskFacade->createTask($taskData);
                $taskCreateNotify = $taskCreateResult ? 'Задача создана' : 'Произошла ошибка';

                $sessionManager = new SessionManager();
                $sessionManager->set('notify', $taskCreateNotify);

                header('Location: /');
                exit();
            } catch (TaskFacadeException $exception) {
                $viewData = array_merge($viewData, $taskData);
                $viewData['error'] = $exception->getMessage();
            }
        }

        (new View())->render('/public/pages/task/edit.php', $viewData);
    }

    public function edit(): void {
        $userFacade = new UserFacade();
        if (!$userFacade->isAuthorized()) {
            header('Location: /login/');
            exit();
        }

        $taskId = $this->request->getGet('id');
        if ($taskId < 1) {
            header('Location: /');
            exit();
        }

        $viewData = array('title' => 'Edit task №' . $taskId);
        $taskFacade = new TaskFacade();

        $taskEntry = $taskFacade->findOneById($taskId);
        if (!$taskEntry) {
            header('Location: /');
            exit();
        }

        if ($this->request->hasPost('edit')) {

            $taskData = array(
                'userName' => $this->request->getPost('userName'),
                'email' => $this->request->getPost('email'),
                'description' => $this->request->getPost('description')
            );

            if ($taskFacade->updateTask($taskId, $taskData)) {
                if ($taskData['description'] !== $taskEntry->getDescription()) {
                    $taskFacade->markAdminEditStatus($taskId);
                }
                header('Location: /');
                exit();
            }

            $viewData['error'] = 'Произошла ошибка при редактировании задачи';
        }

        $viewData['id'] = $taskEntry->getId();
        $viewData['userName'] = $taskEntry->getUserName();
        $viewData['email'] = $taskEntry->getEmail();
        $viewData['description'] = $taskEntry->getDescription();

        (new View())->render('/public/pages/task/edit.php', $viewData);
    }

    public function success(): void {
        $taskId = $this->request->getGet('id');
        if ($taskId < 1) {
            header('Location: /');
            exit();
        }

        $taskFacade = new TaskFacade();
        $taskFacade->markSuccessStatus($taskId);
        header('Location: /');
    }
}