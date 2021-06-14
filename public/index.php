<?php

require_once dirname(__DIR__) . '/config/constants.php';
require_once dirname(__DIR__) . '/config/functions.php';
require_once dirname(__DIR__) . '/config/initializer.php';
require_once dirname(__DIR__) . '/vendor/autoload.php';

use Core\DBConnection;
use Core\Exceptions\ExceptionDistributor;
use Core\Router\Router;
use Core\Request;

ExceptionDistributor::getInstance();

DBConnection::setup();

$router = new Router(Request::getInstance());

require_once ROUTES_DIR . '/routes.php';

$router->run();