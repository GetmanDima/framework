<?php


namespace Core\Exceptions;


use Core\View;

class ErrorHandler
{
    public function __construct()
    {
        http_response_code(500);
    }

    public function production()
    {
        $title = "Error";

        View::render(
            'exceptions/production/unknown_error',
            'templates/error',
            ['title' => $title]
        );
    }

    /**
     * @param array $error
     */
    public function development(array $error)
    {
        $title = "Error";

        View::render(
            'exceptions/development/error',
            'templates/error',
            ['title' => $title, 'error' => $error]
        );
    }
}