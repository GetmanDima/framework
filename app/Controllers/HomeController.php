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
        $user = $this->getLoggedUser();
        $message = $this->request->session()->getFlash('message');

        $this->validate();
        $this->render('home', 'templates/default', compact('title', 'user', 'message'));
    }
}