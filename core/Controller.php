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
     * This is a wrapper for View::render
     *
     * @param string $view
     * @param string $template
     * @param array $vars
     */
    public function render($view = '', $template = '', $vars = [])
    {
        if ($view === '') {
            View::render($this->view, $this->template, $this->vars);
        } else {
            View::render($view, $template, $vars);
        }
    }
}