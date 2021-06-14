<?php


namespace Core\Router;


use Core\Controller;
use Core\Middleware\MiddlewareHandler;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;
use Core\Request;

class Router
{
    /**
     * @var Request
     */
    private Request $request;
    /**
     * @var Dispatcher
     */
    private Dispatcher $dispatcher;
    /**
     * @var array
     */
    private array $routes = [];
    /**
     * @var array
     */
    private array $dispatchedRoute = [];


    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Add a route to list of routes
     *
     * @param string $httpMethod
     * @param string $pattern
     * @param string $handler
     * @param string $name
     */
    public function add($httpMethod, $pattern, $handler, $name = '')
    {
        if ($name === '') {
            $this->routes[] = ['httpMethod' => $httpMethod, 'pattern' => $pattern, 'handler' => $handler];
        } else {
            $this->routes[$name] = [
                'httpMethod' => $httpMethod,
                'pattern' => $pattern,
                'handler' => $handler
            ];
        }
    }

    /**
     * Add a get route to list of routes
     *
     * @param string $pattern
     * @param string $handler
     * @param string $name
     */
    public function get($pattern, $handler, $name = '')
    {
        if ($name === '') {
            $this->routes[] = ['httpMethod' => 'GET', 'pattern' => $pattern, 'handler' => $handler];
        } else {
            $this->routes[$name] = ['httpMethod' => 'GET', 'pattern' => $pattern, 'handler' => $handler];
        }
    }

    /**
     * Add a post route to list of routes
     *
     * @param string $pattern
     * @param string $handler
     * @param string $name
     */
    public function post($pattern, $handler, $name = '')
    {
        if ($name === '') {
            $this->routes[] = ['httpMethod' => 'POST', 'pattern' => $pattern, 'handler' => $handler];
        } else {
            $this->routes[$name] = ['httpMethod' => 'POST', 'pattern' => $pattern, 'handler' => $handler];
        }
    }

    /**
     * Create dispatcher. Run dispatch. Run the handler of dispatched route.
     */
    public function run()
    {
        $this->createDispatcher();
        $this->dispatch();
        $this->handleDispatchedRoute();
    }

    /**
     * @return Dispatcher
     */
    private function createDispatcher(): Dispatcher
    {
        $this->dispatcher = simpleDispatcher(function (RouteCollector $rc) {
            foreach ($this->routes as $route) {
                $pattern = PatternEditor::convertUserPattern($route['pattern']);

                $rc->addRoute($route['httpMethod'],
                    $pattern,
                    $route['handler']);
            }
        });

        return $this->dispatcher;
    }

    /**
     * Run dispatch.
     * It is wrapper to Dispatcher::dispatch (return the same result)
     *
     * @return array
     */
    private function dispatch(): array
    {
        $httpMethod = $this->request->getHttpMethod();
        $stripedUri = $this->request->getUriWithoutQueryString();

        $this->dispatchedRoute = $this->dispatcher->dispatch($httpMethod, $stripedUri);

        return $this->dispatchedRoute;
    }

    /**
     * Handle (run controller action or error handler) the dispatched route.
     */
    private function handleDispatchedRoute()
    {
        switch ($this->dispatchedRoute[0]) {
            case Dispatcher::NOT_FOUND:
                // ... 404 Not Found
                echo '404';
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $this->dispatchedRoute[1];
                // ... 405 Method Not Allowed
                echo '405 <br>';
                var_dump($allowedMethods);
                break;
            case Dispatcher::FOUND:
                $routerData = $this->getDispatchedRouteData();

                $controller = $routerData['controller'];
                $action = $routerData['action'];
                $vars = $routerData['vars'];

                $this->setRouterDataInRequest($controller, $action, $vars);
                $this->runControllerAction($controller, $action, $vars);
                break;
        }
    }

    /**
     * @return array
     */
    private function getDispatchedRouteData(): array
    {
        $handler = $this->dispatchedRoute[1];
        $vars = $this->dispatchedRoute[2];

        list($controllerName, $action) = explode("@", $handler, 2);

        $controller = CONTROLLERS_NAMESPACE . $controllerName;

        return compact('controller', 'action', 'vars');
    }

    /**
     * @param string $controller
     * @param string $action
     * @param array $vars
     */
    private function setRouterDataInRequest(string $controller, string $action, array $vars)
    {
        $this->request->setRouterData(
            compact('controller', 'action', 'vars')
        );
    }

    /**
     * Run controller's action for dispatched route
     *
     * @param string $controller
     * @param string $action
     * @param array $vars
     */
    private function runControllerAction(string $controller, string $action, array $vars)
    {
        $controllerInstance = new $controller;
        $controllerInstance->setRequest($this->request);

        $controllerAction = function() use ($controllerInstance, $action, $vars) {
            call_user_func_array(array($controllerInstance, $action), $vars);
        };

        $this->runAfterMiddleware($controllerInstance, $controllerAction);
    }

    /**
     * Run controller action after middleware check
     *
     * @param Controller $controller
     * @param callable $controllerAction
     */
    private function runAfterMiddleware(Controller $controller, callable $controllerAction)
    {
        $middlewareNames = $controller->getMiddleware();

        $middlewareHandler = new MiddlewareHandler($this->request, $controllerAction);
        $middlewareHandler->selectMiddleware($middlewareNames);
        $middlewareHandler->runMiddleware();
    }
}