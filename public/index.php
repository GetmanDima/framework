<?php

require_once dirname(__DIR__) . '/config/constants.php';
require_once dirname(__DIR__) . '/config/functions.php';
require_once dirname(__DIR__) . '/config/initializer.php';
require_once dirname(__DIR__) . '/vendor/autoload.php';

use Core\DBConnection;
use Core\Router\Router;
use Core\Request;

DBConnection::setup();

$router = new Router(Request::getInstance());

$router->get('/', 'HomeController@index');

$router->get('/register', 'Auth\\RegisterController@showRegistrationForm');
$router->post('/register', 'Auth\\RegisterController@register');

$router->get('/login', 'Auth\\LoginController@showLoginForm');
$router->post('/login', 'Auth\\LoginController@login');
$router->post('/logout', 'Auth\\LoginController@logout');

$router->get('/verify/{token:all}', 'Auth\\EmailVerificationController@verify');

$router->get('/password/reset', 'Auth\\ForgotPasswordController@showForgotPasswordForm');
$router->get('/password/reset/{token:all}', 'Auth\\ForgotPasswordController@showResetPasswordForm');
$router->post('/password/reset', 'Auth\\ForgotPasswordController@reset');
$router->post('/password/email', 'Auth\\ForgotPasswordController@sendResetMessage');

$router->get('/users', 'UserController@index');

$router->run();