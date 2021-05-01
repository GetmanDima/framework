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
    protected $middlewareContainer = [];

    /**
     * @return array
     */
    public function getMiddleware(): array
    {
        return $this->middlewareContainer;
    }

    /**
     * @param array $middleware
     * @param string $action
     */
    public function middleware(array $middleware, string $action = ''): void
    {
        $items = array_map(
            function ($m) use ($action) {
                return ['name' => $m, 'action' => $action];
            },
            $middleware
        );

        $this->middlewareContainer = array_merge($this->middlewareContainer, $items);
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