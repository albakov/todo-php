<?php

namespace TodoPhp\Controller;

class BaseController
{
    protected function redirect(string $url)
    {
        header("Location: {$url}", true, '302');
        die();
    }

    protected function isAdmin()
    {
        return isset($_SESSION['auth_user']) && (int)$_SESSION['auth_user'] === 1;
    }
}