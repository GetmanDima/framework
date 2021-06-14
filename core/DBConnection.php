<?php


namespace Core;


use Illuminate\Database\Capsule\Manager as Capsule;

require_once CONFIG_DIR . '/db.php';

/**
 * Class for database connection.
 * Currently only mysql connection is present.
 * In the future, it is planned to support other DBMS
 *
 * Class DBConnection
 * @package Core
 */
class DBConnection
{
    /**
     * Setup database connection
     *
     * @param string|null $dbname
     * @param string|null $username
     * @param string|null $password
     */
    public static function setup(
        string $dbname = null,
        string $username = null,
        string $password = null
    )
    {
        $capsule = new Capsule;

        $capsule->addConnection([
            'driver' => 'mysql',
            'host' => DB_HOST,
            'port' => DB_PORT,
            'database' => $dbname ? $dbname : DB_NAME,
            'username' => $username ? $username : DB_USER,
            'password' => $password ? $password : DB_PASSWORD,
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ]);

        $capsule->bootEloquent();
    }
}
