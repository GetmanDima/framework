<?php

require_once dirname(__DIR__) . '/config/constants.php';
require_once dirname(__DIR__) . '/config/functions.php';
require_once dirname(__DIR__) . '/config/initializer.php';
require_once dirname(__DIR__) . '/vendor/autoload.php';


use Core\Router\Router;
use Core\Request;

Request::init();

$router = new Router();

$router->get('/', 'HomeController@index');
$router->get('/user/{id:int}', 'HomeController@index');

$router->run();