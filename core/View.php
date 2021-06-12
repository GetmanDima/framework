<?php


namespace Core;


class View {

    private static $viewsDir = PUBLIC_DIR . '/views';


    /**
     * Render view
     *
     * @param string $view
     * @param string $template
     * @param array $vars
     */
    public static function render($view, $template = '', $vars = [])
    {
        extract($vars);

        if ($template === '') {
            if (file_exists(self::$viewsDir . "/{$view}.php")) {
                include_once self::$viewsDir . "/{$view}.php";
            }
        } else if (file_exists(self::$viewsDir . "/{$template}.php")) {
            include_once self::$viewsDir . "/{$template}.php";
        }
    }

    /**
     * @param string $dir
     */
    public static function setViewsDir($dir)
    {
        self::$viewsDir = $dir;
    }
}