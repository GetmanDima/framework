<?php


namespace Core\Router;


class PatternEditor
{
    /**
     * Patterns for converting var type to regex
     *
     * @var array
     */
    private static $patterns = [
        'int' => '[0-9]+',
        'str' => '[a-zA-Z]+',
        'all' => '.*'
    ];


    /**
     * Convert user pattern to regex
     * Example:
     * example.loc/{something:int} will be example.loc/{something:[0-9]+}
     * example.loc/{something:str} will be example.loc/{something:[a-zA-Z]+}
     * example.loc/{something:all} will be example.loc/{something:[a-zA-Z]+}
     *
     * @param string $pattern
     * @return string
     */
    public static function convertUserPattern($pattern): string
    {
        if (strpos($pattern, '{') === false) {
            return $pattern;
        }

        return preg_replace_callback('#{(\w+):(\w+)}#',
            [self::class, 'replacePattern'],
            $pattern);
    }

    /**
     * Replace matched parts with regex in pattern string
     *
     * @param array $matches
     * @return string
     * @throws \Exception
     */
    private static function replacePattern(array $matches): string
    {
        $varName = $matches[1];
        $varType = $matches[2];

        if (!isset(self::$patterns[$varType])) {
            throw new \Exception("Unknown variable type: $varType");
        }

        return '{' . $varName . ':' . self::$patterns[$varType] . '}';
    }
}