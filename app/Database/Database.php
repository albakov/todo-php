<?php

namespace TodoPhp\Database;

use PDO;

class Database
{
    private static $instance;

    private function __construct()
    {
    }

    public static function connection()
    {
        if (is_null(self::$instance)) {
            self::$instance = new PDO("mysql:dbname={$_ENV['DB_NAME']};host={$_ENV['DB_HOST']}", $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
        }

        return self::$instance;
    }
}