<?php

use Core\Session;

// session_start();
const BASE_PATH = __DIR__ . '/../';
// var_dump(BASE_PATH);

require BASE_PATH.'Core/functions.php';
// require './Seeder.php';


spl_autoload_register(function($class)
{

    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
// var_dump($class);
    require base_path("{$class}.php");
});

require base_path('bootstrap.php');

$router = new \Core\Router();

$routes = require base_path('routes.php');
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];
// dd($uri);
$router->route($uri, $method);

// Session::unflash();
// unset($_SESSION['_flashed']);/
// require  base_path('Core/Router.php');




