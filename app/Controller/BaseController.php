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
        $errorMessage = isset($_GET['error_message']) && !empty($_GET['error_message']) ? $_GET['error_message'] : null;

        if (!empty($error)) {
            foreach ($this->fields as $key => $field) {
                if ($key === $_GET['error']) {
                    $errors[] = "Проверьте поле {$field['label']}";
                }
            }
        }

        if (!empty($errorMessage)) {
            $errors[] = $errorMessage;
        }

        return $errors;
    }
}