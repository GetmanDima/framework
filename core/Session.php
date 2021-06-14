<?php


namespace Core;


class Session
{
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
    public function set(string $name, $value)
    {
        $_SESSION[$name] = $value;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function get(string $name)
    {
        if ($this->has($name)) {
            return $_SESSION[$name];
        } else {
            return null;
        }
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool
    {
        return isset($_SESSION[$name]);
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $_SESSION;
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function setFlash(string $name, $value)
    {
        $this->set(
            'flashes',
            array_merge($this->get('flashes') ?? [], [$name => $value])
        );
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function getFlash(string $name)
    {
        $flashes = $this->get('flashes');

        if ($this->hasFlash($name)) {
            return $flashes[$name];
        }

        return null;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasFlash(string $name): bool
    {
        $flashes = $this->get('flashes');

        return isset($flashes) && array_key_exists($name, $flashes);
    }

    /**
     * @param string $name
     */
    public function remove(string $name)
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
        $this->remove('flashes');
    }

    public function removeAll()
    {
        session_unset();
    }
}