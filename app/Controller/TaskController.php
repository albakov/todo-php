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

        $this->redirect('/');
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

        TemplateController::render('pages/edit', compact('item', 'fields', 'id', 'errors'));
    }

    public function update()
    {
        if (!$this->isAdmin()) {
            $this->redirect('/login');
        }

        $id = $this->getItemIdFromRequestOrFail();

        $fields = array_keys($this->fields);
        $fields[] = 'status';
        $postFields = [];

        foreach ($fields as $k) {
            if (!isset($_POST[$k]) || $_POST[$k] === '') {
                $this->redirect("/edit?id={$_GET['id']}&error={$k}");
            }

            $postFields[$k] = htmlentities($_POST[$k]);
        }

        (new Task)->update($id, $postFields);

        $this->redirect("/edit?id={$_GET['id']}");
    }

    private function getItemIdFromRequestOrFail(): ?int
    {
        $id = isset($_GET['id']) && !empty($_GET['id']) ? (int)$_GET['id'] : 0;

        if ($id === 0) {
            $this->redirect('/');
        }

        return $id;
    }
}