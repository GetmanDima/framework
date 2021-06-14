<?php


namespace Core;


class View {

    private static string $viewsDir = PUBLIC_DIR . '/views';


    /**
     * Render view
     *
     * @param string $view
     * @param string $template
     * @param array $vars
     */
    public static function render(string $view, string $template = '', array $vars = [])
    {
        extract($vars);

        $viewPath = self::$viewsDir . "/{$view}.php";
        $templatePath = self::$viewsDir . "/{$template}.php";

        if ($template === '' && file_exists($viewPath)) {
            include_once $viewPath;
        } else if (file_exists($templatePath)) {
            ob_start();
            include_once $viewPath;
            $view = ob_get_clean();

            include_once $templatePath;
        }
    }

    /**
     * @param string $dir
     */
    public static function setViewsDir(string $dir)
    {
        self::$viewsDir = $dir;
    }
}