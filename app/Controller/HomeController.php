<?php

namespace TodoPhp\Controller;

use TodoPhp\Model\Task;

class HomeController extends BaseController
{
    private $perPage = 3;

    private $sortFields = [
        'user_name:asc' => 'Имя ↓',
        'user_name:desc' => 'Имя ↑',
        'user_email:asc' => 'E-mail ↓',
        'user_email:desc' => 'E-mail ↑',
        'status:asc' => 'Статус ↓',
        'status:desc' => 'Статус ↑',
    ];

    public function index()
    {
        $requestedPage = $this->getPage();
        $requestedSort = $this->getSort();
        $requestedSort = implode(':', $requestedSort);

        $task = new Task;
        $total = $task->total();
        $items = $total > 0 ? $task->get($this->getSort(), $this->perPage * ($requestedPage - 1), $this->perPage) : [];

        $sortFields = $this->sortFields;
        $isAdmin = $this->isAdmin();
        $perPage = $this->perPage;
        $isCreated = $this->isTaskCreated();

        TemplateController::render('pages/index', compact('items', 'total', 'sortFields', 'isAdmin', 'requestedSort', 'requestedPage', 'perPage', 'isCreated'));
    }

    private function getPage()
    {
        return isset($_GET['p']) && !empty($_GET['p']) ? (int)$_GET['p'] : 1;
    }

    private function getSort()
    {
        if (isset($_GET['sort']) && !empty($_GET['sort'])) {
            $sort = explode(':', $_GET['sort']);

            if (count($sort) === 2 && in_array($sort[0], ['user_name', 'user_email', 'status']) && in_array($sort[1], ['asc', 'desc'])) {
                return $sort;
            }
        }

        return ['id', 'desc'];
    }

    private function isTaskCreated()
    {
        return isset($_GET['created']) && !empty($_GET['created']);
    }
}