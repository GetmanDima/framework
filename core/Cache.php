<?php


namespace Core;


use function PHPUnit\Framework\fileExists;

class Cache
{
    /**
     * @param int $id
     * @param string $controller
     * @param string $action
     * @param mixed $data
     */
    public function set(int $id, string $controller, string $action, $data)
    {
        if (!is_dir(APP_CACHE_DIR . "/$controller/$action")) {
            mkdir(APP_CACHE_DIR . "/$controller/$action", 0777, true);
        }

        $filePath = APP_CACHE_DIR . "/$controller/$action/$id.tmp";
        $file = fopen($filePath, 'wb');

        if (is_writable($filePath)) {
            fwrite($file, serialize($data));
        } else {
            echo 'write error';
        }

        fclose($file);
    }

    /**
     * @param int $id
     * @param string $controller
     * @param string $action
     * @return mixed|null
     */
    public function get(int $id, string $controller, string $action)
    {
        $filePath = APP_CACHE_DIR . "/$controller/$action/$id.tmp";

        if (file_exists($filePath) && filesize($filePath) > 0) {
            $file = fopen($filePath, 'rb');
            $data = fread($file, filesize($filePath));
            fclose($file);

            return unserialize($data);
        }

        return null;
    }

    /**
     * @param int $id
     * @param string $controller
     * @param string $action
     */
    public function remove(int $id, string $controller, string $action)
    {
        $filePath = APP_CACHE_DIR . "/$controller/$action/$id.tmp";

        if (fileExists($filePath)) {
            unlink($filePath);
        }
    }
}