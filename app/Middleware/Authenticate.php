<?php


namespace App\Middleware;


use Core\Middleware\Middleware;
use Core\Request;

class Authenticate extends Middleware
{
    public function handle(Request $request)
    {
        $this->next();
    }
}