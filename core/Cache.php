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
     * @param int $lifeTime
     */
    public function set(int $id, string $controller, string $action, $data, int $lifeTime = 3600)
    {
        if (!is_dir(APP_CACHE_DIR . "/$controller/$action")) {
            mkdir(APP_CACHE_DIR . "/$controller/$action", 0777, true);
        }

        $filePath = APP_CACHE_DIR . "/$controller/$action/$id.tmp";
        $file = fopen($filePath, 'wb');

        if (is_writable($filePath)) {
            fwrite($file, serialize(compact('data', 'lifeTime')));
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
            $dataWithLifeTime = unserialize(fread($file, filesize($filePath)));
            fclose($file);

            $lifeTime = $dataWithLifeTime['lifeTime'];
            $data = $dataWithLifeTime['data'];

            if (time() - $lifeTime > filemtime($filePath)) {
                $this->remove($id, $controller, $action);

                return null;
            }

            return $data;
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