<?php


namespace Core\Exceptions;


use Core\View;

class ExceptionHandler
{
    public function productionError404()
    {
        http_response_code(404);

        $title = 'Error 404';

        View::render(
            'exceptions/production/error404',
            'templates/error',
            compact('title')
        );
    }
}