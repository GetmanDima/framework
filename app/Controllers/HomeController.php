<?php


namespace App\Controllers;


use Core\Controller;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->view = 'home';
    }

    public function index()
    {
        $this->render();
    }
}