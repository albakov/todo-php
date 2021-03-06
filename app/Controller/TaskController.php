<?php

namespace TodoPhp\Controller;

use TodoPhp\Model\Task;

class TaskController extends BaseController
{
    protected $fields = [
        'user_name' => [
            'label' => 'Имя',
            'type' => 'text'
        ],
        'user_email' => [
            'label' => 'Email',
            'type' => 'email'
        ],
        'task_text' => [
            'label' => 'Текст',
            'type' => 'textarea'
        ],
    ];

    public function create()
    {
        $fields = $this->fields;
        $errors = $this->getErrors();

        TemplateController::render('pages/create', compact('fields', 'errors'));
    }

    public function store()
    {
        $fields = array_keys($this->fields);
        $postFields = [];

        foreach ($fields as $k) {
            if (!isset($_POST[$k]) || $_POST[$k] === '') {
                $this->redirect("/create?error={$k}");
            }

            $postFields[$k] = htmlentities($_POST[$k]);
        }

        (new Task)->add($postFields);

        $this->redirect('/?created=1');
    }

    public function edit()
    {
        if (!$this->isAdmin()) {
            $this->redirect('/login');
        }

        $id = $this->getItemIdFromRequestOrFail();

        $fields = $this->fields;

        $task = new Task;
        $item = $task->getById($id);

        if (!$item) {
            $this->redirect('/not-found');
        }

        $errors = $this->getErrors();
        $isUpdated = $this->isTaskUpdated();

        TemplateController::render('pages/edit', compact('item', 'fields', 'id', 'errors', 'isUpdated'));
    }

    public function update()
    {
        if (!$this->isAdmin()) {
            $this->redirect('/login');
        }

        $id = $this->getItemIdFromRequestOrFail();

        $task = new Task;
        $item = $task->getById($id);

        if (!$item) {
            $this->redirect('/not-found');
        }

        $fields = array_keys($this->fields);
        $fields[] = 'status';
        $postFields = [];

        foreach ($fields as $k) {
            if (!isset($_POST[$k]) || $_POST[$k] === '') {
                $this->redirect("/edit?id={$_GET['id']}&error={$k}");
            }

            $postFields[$k] = htmlentities($_POST[$k]);
        }

        if ($item['task_text'] !== $postFields['task_text']) {
            $postFields['edit'] = 1;
        }

        (new Task)->update($id, $postFields);

        $this->redirect("/edit?id={$_GET['id']}&updated=1");
    }

    private function getItemIdFromRequestOrFail(): ?int
    {
        $id = isset($_GET['id']) && !empty($_GET['id']) ? (int)$_GET['id'] : 0;

        if ($id === 0) {
            $this->redirect('/');
        }

        return $id;
    }

    private function isTaskUpdated()
    {
        return isset($_GET['updated']) && !empty($_GET['updated']);
    }
}