<?php
require_once 'core/bootstrap.php';

$routes = require_once  'app/routes.php';
$router = new Router($routes);
App::bind('router', $router);

App::bind('connection', Connection::make(App::get('config')['database']));

require $router->direct(Request::uri());