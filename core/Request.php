<?php


namespace Core;


class Request
{
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
    private static $session;


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
        $this->validator = new Validator();

        $this->session->start();
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
}