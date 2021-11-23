<?php
use ProyectoWeb\core\App;
use ProyectoWeb\core\Request;
use ProyectoWeb\core\Router;
use ProyectoWeb\database\Connection;

$config = require_once __DIR__ . '/../app/config.php';
App::bind('config', $config);