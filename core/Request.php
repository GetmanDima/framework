<?php


namespace Core;


use Rakit\Validation\Validation;
use Rakit\Validation\Validator;

class Request
{
    /**
     * @var string
     */
    const VALIDATION_RULES_PATH = CONFIG_DIR . '/validationRules.php';
    /**
     * The Singleton's instance
     *
     * @var Request
     */
    private static $instance;
    /**
     * @var string
     */
    private $httpMethod;
    /**
     * @var string
     */
    private $uri;
    /**
     * @var array
     */
    private $post = [];
    /**
     * @var array
     */
    private $get = [];
    /**
     * @var array
     */
    private $files = [];
    /**
     * @var Cookie
     */
    private $cookie;
    /**
     * @var Session
     */
    private $session;
    /**
     * @var Validator
     */
    private $validator;
    /**
     * @var array
     */
    private $routerData = [
        'controller' => '',
        'action' => '',
        'vars' => []
    ];

    /**
     * Controls the access to the singleton instance
     *
     * @return Request
     */
    public static function getInstance(): Request
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function __construct()
    {
        $this->httpMethod = $_SERVER['REQUEST_METHOD'];
        $this->uri = rawurldecode($_SERVER['REQUEST_URI']);
        $this->get = $_GET;
        $this->post = $_POST;
        $this->files = $_FILES;
        $this->cookie = new Cookie();
        $this->session = new Session();

        $this->initValidator();
        $this->session->start();
    }

    public function initValidator()
    {
        $validator = new Validator();

        $rules = require_once self::VALIDATION_RULES_PATH;

        foreach ($rules as $name => $handler) {
            $validator->addValidator($name, new $handler);
        }

        $this->validator = $validator;
    }

    /**
     * @return string
     */
    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * Return URI without query string.
     * Example: example.loc/something?v=1 return example.loc/something
     *
     * @return string
     */
    public function getUriWithoutQueryString(): string
    {
        $separatorIndex = strpos($this->uri, '?');

        if ($separatorIndex !== false) {
            return substr($this->uri, 0, $separatorIndex);
        }

        return $this->uri;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function get($name)
    {
        return $this->get[$name];
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function post($name)
    {
        return $this->post[$name];
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function files($name)
    {
        return $this->files[$name];
    }

    /**
     * @return Cookie
     */
    public function cookie(): Cookie
    {
        return $this->cookie;
    }

    /**
     * @return Session
     */
    public function session(): Session
    {
        return $this->session;
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return [
            'httpMethod' => $this->httpMethod,
            'uri' => $this->uri,
            'get' => $this->get,
            'post' => $this->post,
            'files' => $this->files,
            'cookie' => $this->cookie,
            'session' => $this->session
        ];
    }

    /**
     * @param array $inputNames
     * @param array $rules
     * @return Validation
     */
    public function validation($inputNames, $rules): Validation
    {
        $inputs = $this->getInputsByNames($inputNames);

        return $this->validator->make($inputs, $rules);
    }

    /**
     * @return array
     */
    public function getRouterData(): array
    {
        return $this->routerData;
    }

    /**
     * @param array $routerData
     */
    public function setRouterData(array $routerData): void
    {
        $this->routerData = $routerData;
    }

    /**
     * @param array $inputNames
     * @return array
     */
    private function getInputsByNames($inputNames): array
    {
        $all = $this->all();
        $inputs = [];

        foreach ($inputNames as $inputName) {
            $inputs += $all[$inputName];
        }

        return $inputs;
    }
}