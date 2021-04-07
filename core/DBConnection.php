<?php


namespace Core;


use \RedBeanPHP\R as R;

require_once CONFIG_DIR . '/db.php';

/**
 * Class DBConnection
 * @package Core
 *
 * Class for database connection.
 * Currently only mysql connection is present.
 * In the future, it is planned to support other DBMS
 */
class DBConnection
{
    /**
     * Setup connection to database.
     * Wrapper for \Redbean\R::setup.
     *
     * @param string|null $host
     * @param string|null $dbname
     * @param string|null $user
     * @param string|null $password
     */
    public static function setup($host = null, $dbname = null, $user = null, $password = null)
    {
        if ($host !== null && $dbname !== null && $user !== null && $password !== null) {
            $dsn = "mysql:host=$host;dbname=$dbname";

            R::setup($dsn, $user, $password);
        } else {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;

            R::setup($dsn, DB_USER, DB_PASSWORD);
        }
    }
}
