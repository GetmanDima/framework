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
    public function set($name, $value, $minutes = 0, $path = '/')
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
    public function get($name)
    {
        if ($this->has($name)) {
            return $_COOKIE[$name];
        } else {
            throw new \Exception("Undefined cookie variable name: $name");
        }
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has($name): bool
    {
        return isset($_COOKIE[$name]);
    }

    /**
     * @param string $name
     * @param string $path
     */
    public function remove($name, $path = '/')
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