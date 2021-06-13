<?php


namespace App\Controllers;


use App\Models\User;

class UserController extends AppController
{
    public function index()
    {
        $title = 'Users';
        $cache = $this->request->cache();
        $users = $cache->get(1, 'UserController', 'index');

        if ($users === null) {
            $users = User::findAll();
            $cache->set(1, 'UserController', 'index', $users);
        }

        $this->render('users', 'templates/default', compact('title', 'users'));
    }
}