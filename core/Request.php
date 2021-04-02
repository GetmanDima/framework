<?php


namespace Core;


class Request
{
    /**
     * @var string
     */
    private static $httpMethod;
    /**
     * @var string
     */
    private static $uri;
    /**
     * @var array
     */
    private static $post = [];
    /**
     * @var array
     */
    private static $get = [];
    /**
     * @var array
     */
    private static $files = [];
    /**
     * @var Cookie
     */
    private static $cookie;
    /**
     * @var Session
     */
    private static $session;


    public static function init()
    {
        self::$httpMethod = $_SERVER['REQUEST_METHOD'];
        self::$uri = rawurldecode($_SERVER['REQUEST_URI']);
        self::$get = $_GET;
        self::$post = $_POST;
        self::$files = $_FILES;
        self::$cookie = new Cookie();
        self::$session = new Session();
    }

    /**
     * @return string
     */
    public static function getHttpMethod(): string
    {
        return self::$httpMethod;
    }

    /**
     * @return string
     */
    public static function getUri(): string
    {
        return self::$uri;
    }

    /**
     * Return URI without query string.
     * Example: example.loc/something?v=1 return example.loc/something
     *
     * @return string
     */
    public static function getUriWithoutQueryString(): string
    {
        $separatorIndex = strpos(self::$uri, '?');

        if ($separatorIndex !== false) {
            return substr(self::$uri, 0, $separatorIndex);
        }

        return self::$uri;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public static function get($name)
    {
        return self::$get[$name];
    }

    /**
     * @param string $name
     * @return mixed
     */
    public static function post($name)
    {
        return self::$post[$name];
    }

    /**
     * @param string $name
     * @return mixed
     */
    public static function files($name)
    {
        return self::$files[$name];
    }

    /**
     * @return Cookie
     */
    public function cookie(): Cookie
    {
        return self::$cookie;
    }

    /**
     * @return Session
     */
    public static function session(): Session
    {
        return self::$session;
    }
}