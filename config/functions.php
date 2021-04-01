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

function debug($var)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}

function dd($var)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';

    die();
}