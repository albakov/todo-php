<?php

namespace TodoPhp\Controller;

class AuthController extends BaseController
{
    private $fields = [
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

        TemplateController::render('pages/login', compact('fields'));
    }

    public function auth()
    {
        $fields = array_keys($this->fields);

        foreach ($fields as $k) {
            if (!isset($_POST[$k]) || $_POST[$k] === '') {
                $this->redirect("/login?error={$k}");
            }
        }

        if ($_POST['name'] !== 'admin' || $_POST['password'] !== '123') {
            $this->redirect("/login?error=password");
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