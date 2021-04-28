<?php


namespace Core\Middleware;


use Core\Request;

class MiddlewareHandler
{
    /**
     * Path to middleware list
     *
     * @var string
     */
    private $path = APP_DIR . '/middleware.php';
    /**
     * @var Request
     */
    private $request;
    /**
     * @var callable
     */
    private $controllerAction;
    /**
     * @var array
     */
    private $middleware = [];
    /**
     * @var Middleware[]
     */
    private $selectedMiddleware = [];


    /**
     * MiddlewareHandler constructor.
     * @param Request $request
     * @param callable $controllerAction
     */
    public function __construct(Request $request, callable $controllerAction)
    {
        $this->request = $request;
        $this->controllerAction = $controllerAction;
        $this->middleware = require_once $this->path;
    }

    /**
     * @param array $names
     */
    public function selectMiddleware(array $names): void
    {
        if (count($names) < 1) {
            return;
        }

        foreach ($names as $name) {
            if (key_exists($name, $this->middleware)) {
                $instance = new $this->middleware[$name];
                $this->selectedMiddleware[] = $instance;
            }
        }
    }

    public function runMiddleware() {
        if (count($this->selectedMiddleware) > 0) {
            $this->createMiddlewareQueue();
            $this->selectedMiddleware[0]->handle($this->request);
        }
    }

    private function createMiddlewareQueue(): void
    {
        if (count($this->selectedMiddleware) < 1) {
            return;
        }

        $lastIndex = count($this->selectedMiddleware) - 1;

        for ($i = 0; $i < $lastIndex; $i++) {
            $this->selectedMiddleware[$i]->setNext(
                function() use ($i) {
                    $this->selectedMiddleware[$i + 1]->handle($this->request);
                }
            );
        }

        $this->selectedMiddleware[$lastIndex]->setNext($this->controllerAction);
    }
}