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
     * Get $middlewareContainer from Controller
     * Select middleware for current Controller action
     *
     * @param array $middlewareContainer
     */
    public function selectMiddleware(array $middlewareContainer): void
    {
        if (count($middlewareContainer) < 1) {
            return;
        }

        $actionName = $this->request->getRouterData()['action'];

        foreach ($middlewareContainer as $item) {
            if (key_exists($item['name'], $this->middleware)) {
                if ($item['action'] === '' || $item['action'] === $actionName) {
                    $instance = new $this->middleware[$item['name']];
                    $this->selectedMiddleware[] = $instance;
                }
            }
        }
    }

    public function runMiddleware(): void {
        if (count($this->selectedMiddleware) > 0) {
            $this->createMiddlewareQueue();
            $this->selectedMiddleware[0]->handle($this->request);
        } else {
            $controllerAction = $this->controllerAction;
            $controllerAction();
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