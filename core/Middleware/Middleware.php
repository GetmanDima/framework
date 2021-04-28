<?php


namespace Core\Middleware;


use Core\Request;

abstract class Middleware
{
    /**
     * Contain next middleware handle or controller action callback
     *
     * @var callable
     */
    protected $next;

    /**
     * @param Request $request
     * @return mixed
     */
    abstract public function handle(Request $request);

    /**
     * @param callable $next
     */
    public function setNext(callable $next)
    {
        $this->next = $next;
    }

    /**
     * Run $next callback
     */
    protected function next()
    {
        $callback = $this->next;
        $callback();
    }
}