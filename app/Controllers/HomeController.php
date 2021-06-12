<?php


namespace App\Controllers;


class HomeController extends AppController
{
    protected string $failRedirectTo = '/fail';

    /**
     * @return \Rakit\Validation\Validation
     */
    protected function validation(): \Rakit\Validation\Validation
    {
        return $this->request->validation(['get'], ['a' => 'numeric']);
    }

    public function index()
    {
        $title = 'Home';
        $user = $this->request->session()->get('user');

        $this->validate();
        $this->render('home', 'templates/default', compact('title', 'user'));
    }
}