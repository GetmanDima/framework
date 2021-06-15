<?php


namespace Core\Exceptions;


class ExceptionDistributor
{
    const CONFIG_PATH = CONFIG_DIR . '/exception_handlers.php';

    /**
     * The Singleton's instance
     *
     * @var ExceptionDistributor
     */
    private static $instance;

    /**
     * @var \Exception|\Error|\ErrorException
     */
    private $exception;

    /**
     * @var array
     */
    private array $error;

    /**
     * @var array
     */
    private array $handlers = [];

    /**
     * @var string
     */
    private string $currentHandler;

    /**
     * @var string
     */
    private string $currentAction;

    /**
     * Controls the access to the singleton instance
     *
     * @return ExceptionDistributor
     */
    public static function getInstance(): ExceptionDistributor
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function __construct()
    {
        ob_start();

        $handlers = require_once self::CONFIG_PATH;
        $this->handlers = DEBUG_MODE ? $handlers['development'] : $handlers['production'];

        set_error_handler([$this, 'handleError']);
        set_exception_handler([$this, 'handleException']);
    }

    /**
     * @param int $errno
     * @param string $errstr
     * @param string $errfile
     * @param int $errline
     */
    public function handleError(int $errno, string $errstr, string $errfile, int $errline)
    {;
        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        $this->currentHandler = 'Core\\Exceptions\\ErrorHandler';
        $this->currentAction = DEBUG_MODE ? 'development' : 'production';
        $this->error = compact('errno', 'errstr', 'errfile', 'errline');

        $this->runErrorHandlerAction();
    }

    /**
     * @param \Exception|\Error|\ErrorException $exception
     */
    public function handleException($exception)
    {
        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        $this->exception = $exception;

        $this->prepareExceptionHandler();
        $this->runExceptionHandlerAction();

        exit;
    }

    private function prepareExceptionHandler()
    {
        $this->currentHandler = 'Core\\Exceptions\\UnknownExceptionHandler';
        $this->currentAction = DEBUG_MODE ? 'development' : 'production';
        $code = $this->exception->getCode();

        if (array_key_exists($code, $this->handlers)) {
            list($this->currentHandler, $this->currentAction)
                = explode('@', $this->handlers[$code]);
        }
    }

    private function runExceptionHandlerAction()
    {
        if (class_exists($this->currentHandler)) {
            $exceptionHandlerInstance = new $this->currentHandler();
            $action = $this->currentAction;

            if (method_exists($exceptionHandlerInstance, $action)) {
                $exceptionHandlerInstance->$action($this->exception);
            }
        }
    }

    private function runErrorHandlerAction()
    {
        if (class_exists($this->currentHandler)) {
            $errorHandlerInstance = new $this->currentHandler();
            $action = $this->currentAction;

            if (method_exists($errorHandlerInstance, $action)) {
                $errorHandlerInstance->$action($this->error);
            }
        }
    }
}