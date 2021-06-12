<?php


namespace App\Middleware;


use Core\Middleware\Middleware;
use Core\Request;

class RedirectIfAuthenticated extends Middleware
{
    public function handle(Request $request)
    {
        if ($request->session()->get('user')) {
            redirect('/');
        }

        $this->next();
    }
}