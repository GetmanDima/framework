<?php


namespace Core\Exceptions;


use Core\View;

class UnknownExceptionHandler
{
    public function __construct()
    {
        http_response_code(500);
    }

    public function production()
    {
        $title = 'Internal server error';

        View::render(
            'exceptions/production/unknown_error',
            'templates/error',
            compact('title')
        );
    }

    /**
     * @param \Exception|\Error|\ErrorException $exception
     */
    public function development($exception)
    {
        $title = 'Unknown Exception';

        View::render(
            'exceptions/development/unknown_exception',
            'templates/error',
            compact('title', 'exception')
        );
    }
}