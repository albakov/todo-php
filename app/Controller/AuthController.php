<?php

namespace TodoPhp\Controller;

class AuthController extends BaseController
{
    private $credits = [
        'name' => 'admin',
        'password' => '123'
    ];

    protected $fields = [
        'name' => [
            'label' => 'Имя',
            'type' => 'text'
        ],
        'password' => [
            'label' => 'Пароль',
            'type' => 'password'
        ],
    ];

    public function login()
    {
        if ($this->isAdmin()) {
            $this->redirect('/');
        }

        $fields = $this->fields;
        $errors = $this->getErrors();
        $errorMessage = $this->getErrorMessage();

        TemplateController::render('pages/login', compact('fields', 'errors', 'errorMessage'));
    }

    public function auth()
    {
        $fields = array_keys($this->fields);

        foreach ($fields as $k) {
            if (!isset($_POST[$k]) || $_POST[$k] === '') {
                $this->redirect("/login?error={$k}");
            }
        }

        if ($_POST['name'] !== $this->credits['name'] || $_POST['password'] !== $this->credits['password']) {
            $this->redirect('/login?error_message=Логин или пароль не верны!');
        }

        $_SESSION['auth_user'] = 1;

        $this->redirect('/');
    }

    public function logout()
    {
        session_destroy();
        $this->redirect('/');
    }
}