<?php

namespace TodoPhp\Controller;

class BaseController
{
    protected $fields = [];

    protected function redirect(string $url)
    {
        header("Location: {$url}", true, '302');
        die();
    }

    protected function isAdmin()
    {
        return isset($_SESSION['auth_user']) && (int)$_SESSION['auth_user'] === 1;
    }

    protected function getErrors(): array
    {
        $errors = [];
        $error = isset($_GET['error']) && !empty($_GET['error']) ? $_GET['error'] : null;

        if (is_null($error)) {
            return $errors;
        }

        foreach ($this->fields as $key => $field) {
            if ($key === $_GET['error']) {
                $errors[] = "Проверьте поле {$field['label']}";
            }
        }

        return $errors;
    }
}