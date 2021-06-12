<?php


namespace App\Controllers;


use Core\Controller;

class AppController extends Controller
{
    public function isUserLogged()
    {
        return $this->request->session()->get('user') !== null;
    }

    public function getLoggedUser()
    {
        return $this->request->session()->get('user');
    }
}