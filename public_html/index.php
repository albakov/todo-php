<?php
session_start();

use Bramus\Router\Router;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$router = new Router();

// Home
$router->match('GET', '/', '\TodoPhp\Controller\HomeController@index');

// Tasks
$router->match('GET', '/create', '\TodoPhp\Controller\TaskController@create');
$router->match('POST', '/store', '\TodoPhp\Controller\TaskController@store');
$router->match('GET', '/edit', '\TodoPhp\Controller\TaskController@edit');
$router->match('POST', '/update', '\TodoPhp\Controller\TaskController@update');

// Auth
$router->match('GET', '/login', '\TodoPhp\Controller\AuthController@login');
$router->match('POST', '/auth', '\TodoPhp\Controller\AuthController@auth');
$router->match('GET', '/logout', '\TodoPhp\Controller\AuthController@logout');

// 404
$router->set404(function() {
    header('HTTP/1.1 404 Not Found');
});

$router->run();