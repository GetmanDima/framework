<?php


namespace Core;


use Rakit\Validation\Validation;

/**
 * Class Controller
 * @package Core
 *
 * Base controller class. Application controllers should extend from base model.
 */
abstract class Controller
{

    /**
     * @var Request
     */
    protected $request;
    /**
     * Redirect if fail validation
     *
     * @var string
     */
    protected $failRedirectTo = '/';
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
     * @param Request $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

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

    /**
     * Common validation rules (for all actions)
     *
     * @return Validation
     */
    protected function validation()
    {
        return $this->request->validation([], []);
    }

    /**
     * @param Validation|null $validation
     * @param string $successRedirectTo
     * @param string $failRedirectTo
     */
    protected function validate(Validation $validation = null, $failRedirectTo = '')
    {
        if ($failRedirectTo === '') {
            $failRedirectTo = $this->failRedirectTo;
        }

        if ($validation === null) {
            $validation = $this->validation();
        }

        $validation->validate();

        $this->createValidationMessage($validation);

        if ($validation->fails()) {
            redirect($failRedirectTo);
        }
    }

    /**
     * @param Validation $validation
     */
    protected function createValidationMessage(Validation $validation)
    {
        $session = $this->request->session();

        if ($validation->fails()) {
            $errors = $validation->errors();
            $session->flash('validation', 'fail');
            $session->flash('form-errors', $errors->all());
        } else {
            $session->flash('validation', 'success');
        }
    }
}