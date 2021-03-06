<?php

require_once 'constants.php';


function runDebugMode()
{
    error_reporting(-1);
    ini_set('display_errors', 'On');
}

function runProductionMode()
{
    ini_set('display_errors', 'Off');
}

function setCookieLifeTime()
{
    ini_set('session.cookie_lifetime', COOKIE_LIFETIME);
}

function setSessionLifeTime()
{
    ini_set('session.gc_maxlifetime', SESSION_LIFETIME);
}

function debug(...$vars)
{
    foreach ($vars as $var) {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }
}

function dd(...$vars)
{
    foreach ($vars as $var) {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }

    die();
}

/**
 * @param string $url
 */
function redirect(string $url)
{
    header("Location: {$url}");
    exit;
}

/**
 * @param string $view
 * @param array $vars
 */
function includeView(string $view, array $vars)
{
    extract($vars);
    include_once PUBLIC_DIR . '/views/' . $view . '.php';
}
