<?php


namespace App\Controllers;


class HomeController extends AppController
{
    protected string $failRedirectTo = '/fail';

    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(['guest'], 'index');
    }

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

        $this->validate();
        $this->render('home', 'templates/default', compact('title'));
    }
}