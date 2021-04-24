<?php


namespace App\Controllers;


use Core\Controller;
use Core\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->view = 'home';
    }

    public function index(Request $request)
    {
        $this->render();
    }
}