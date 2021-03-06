<?php


namespace Core;


class Cookie
{
    /**
     * Set cookie var.
     * Default minutes = 0 means that cookies will exist until the browser is closed
     *
     * @param string $name
     * @param string $value
     * @param int $minutes
     * @param string $path
     */
    public function set(string $name, string $value, int $minutes = 0, string $path = '/')
    {
        $time = $minutes * 60;

        if ($time !== 0) {
            $time += time();
        }

        setcookie($name, $value, $time, $path);
    }

    /**
     * @param string $name
     * @return mixed
     * @throws \Exception
     */
    public function get(string $name)
    {
        if ($this->has($name)) {
            return $_COOKIE[$name];
        }

        return null;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool
    {
        return isset($_COOKIE[$name]);
    }

    /**
     * @param string $name
     * @param string $path
     */
    public function remove(string $name, string $path = '/')
    {
        if ($this->has($name)) {
            unset($_COOKIE[$name]);
            setcookie($name, null, -1, $path);
        }
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $_COOKIE;
    }
}