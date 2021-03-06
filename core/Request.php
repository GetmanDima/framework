<?php


namespace Core;


use Rakit\Validation\Validation;
use Rakit\Validation\Validator;

class Request
{
    /**
     * @var string
     */
    const VALIDATION_RULES_PATH = CONFIG_DIR . '/validation_rules.php';
    /**
     * The Singleton's instance
     *
     * @var Request
     */
    private static $instance;
    /**
     * @var string
     */
    private string $httpMethod;
    /**
     * @var string
     */
    private string $uri;
    /**
     * @var array
     */
    private array $post;
    /**
     * @var array
     */
    private array $get;
    /**
     * @var array
     */
    private array $files;
    /**
     * @var Cookie
     */
    private Cookie $cookie;
    /**
     * @var Session
     */
    private Session $session;
    /**
     * @var Cache
     */
    private Cache $cache;
    /**
     * @var Validator
     */
    private Validator $validator;
    /**
     * @var array
     */
    private array $routerData = [
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

    /**
     * @throws \Rakit\Validation\RuleQuashException
     */
    public function __construct()
    {
        $this->httpMethod = $_SERVER['REQUEST_METHOD'];
        $this->uri = rawurldecode($_SERVER['REQUEST_URI']);
        $this->get = $_GET;
        $this->post = $_POST;
        $this->files = $_FILES;
        $this->cookie = new Cookie();
        $this->session = new Session();
        $this->cache = new Cache();

        $this->initValidator();
        $this->session->start();
    }

    /**
     * @throws \Rakit\Validation\RuleQuashException
     */
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
    public function get(string $name)
    {
        return $this->get[$name];
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function post(string $name)
    {
        return $this->post[$name];
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function files(string $name)
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
     * @return Cache
     */
    public function cache(): Cache
    {
        return $this->cache;
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
    public function validation(array $inputNames, array $rules): Validation
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
    private function getInputsByNames(array $inputNames): array
    {
        $all = $this->all();
        $inputs = [];

        foreach ($inputNames as $inputName) {
            $inputs += $all[$inputName];
        }

        return $inputs;
    }
}