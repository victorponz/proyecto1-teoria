<?php
session_start();

require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/core/bootstrap.php';
use ProyectoWeb\core\App;
use ProyectoWeb\core\Router;
use ProyectoWeb\core\Request;

use ProyectoWeb\database\Connection;


$routes = require_once __DIR__ . '/../src/app/routes.php';
$router = new Router($routes);
App::bind('router', $router);

App::bind('connection', Connection::make(App::get('config')['database']));

App::bind('rootDir', __DIR__ . '/');


require $router->direct(Request::uri());