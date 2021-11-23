<?php
require_once 'App.php';
require_once 'Request.php';
require_once 'Router.php';
require_once __DIR__ . '/../database/Connection.php';

$config = require_once __DIR__ . '/../app/config.php';
App::bind('config', $config);