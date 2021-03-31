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


    public static function init()
    {
        self::$httpMethod = $_SERVER['REQUEST_METHOD'];
        self::$uri = rawurldecode($_SERVER['REQUEST_URI']);
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
}