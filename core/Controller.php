<?php


namespace Core;


/**
 * Class Controller
 * @package Core
 *
 * Base controller class. Application controllers should extend from base model.
 */
abstract class Controller {

    /**
     * Page template
     *
     * @var string
     */
    protected $template = '';

    /**
     * Page content
     *
     * @var string
     */
    protected $view = '';

    /**
     * Array of view variables
     *
     * @var array
     */
    protected $vars = [];

    /**
     * Array of middleware names
     *
     * @var array
     */
    protected $middleware = [];

    /**
     * @return array
     */
    public function getMiddleware(): array
    {
        return $this->middleware;
    }

    /**
     * @param array $middleware
     */
    public function setMiddleware(array $middleware): void
    {
        $this->middleware = $middleware;
    }

    /**
     * This is a wrapper for View::render
     *
     * @param string $view
     * @param string $template
     * @param array $vars
     */
    protected function render($view = '', $template = '', $vars = [])
    {
        if ($view === '') {
            View::render($this->view, $this->template, $this->vars);
        } else {
            View::render($view, $template, $vars);
        }
    }
}