<?php


namespace Core;


class Session
{
    /**
     * Array of flash names
     *
     * @var array
     */
    private static $flashes = [];

    public function start()
    {
        session_start();
    }

    public function destroy()
    {
        session_destroy();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return session_id();
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    /**
     * @param string $name
     * @return mixed
     * @throws \Exception
     */
    public function get($name)
    {
        if ($this->has($name)) {
            return $_SESSION[$name];
        } else {
            throw new \Exception("Undefined session variable name: $name");
        }
    }

    public function has($name): bool
    {
        return isset($_SESSION[$name]);
    }

    public function all()
    {
        return $_SESSION;
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function flash($name, $value)
    {
        $this->set($name, $value);
        self::$flashes[] = $name;
    }

    /**
     * @param string $name
     */
    public function remove($name)
    {
        if ($this->has($name)) {
            unset($_SESSION[$name]);
        }
    }

    /**
     * Remove flash session vars
     * Need to be called at the end of the program
     */
    public function removeFlashes()
    {
        foreach (self::$flashes as $flash) {
            if ($this->has($flash)) {
                unset($_SESSION[$flash]);
            }
        }
    }

    public function removeAll()
    {
        session_unset();
    }
}