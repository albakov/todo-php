<?php

namespace TodoPhp\Controller;

use Exception;

class TemplateController
{
    public static function render(string $template, array $args = [])
    {
        $path = __DIR__ . "/../View/{$template}.php";

        if (!file_exists($path)) {
            throw new Exception('Template not found!');
        }

        extract($args);

        ob_start();

        require_once $path;

        $html = ob_get_contents();

        ob_end_clean();

        echo $html;

        die();
    }
}