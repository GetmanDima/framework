<?php


namespace App\Controllers;


use Core\SessionMessage;

class HomeController extends AppController
{
    use SessionMessage;

    public function index()
    {
        $title = 'Home';
        $loggedUser = $this->getLoggedUser();
        $alertMessage = $this->getAlertMessage();

        $this->render(
            'home',
            'templates/default',
            compact('title', 'loggedUser', 'alertMessage')
        );
    }
}