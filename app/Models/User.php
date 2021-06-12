<?php


namespace App\Models;


use Core\Model;
use RedBeanPHP\R;

class User extends Model
{
    static $table = 'users';

    /**
     * @throws \RedBeanPHP\RedException\SQL
     */
    public static function create(array $attributes = []): Model
    {
        $attributesWithPasswordHash = $attributes;
        $attributesWithPasswordHash['password'] = password_hash($attributes['password'], PASSWORD_BCRYPT);

        $user = static::dispense($attributesWithPasswordHash);
        $user->store();

        return $user;
    }

    /**
     * @param $email
     * @param $password
     * @return \RedBeanPHP\OODBBean|null
     */
    public static function findByEmailAndPassword($email, $password): ?\RedBeanPHP\OODBBean
    {
        $user = R::findOne(static::$table, "email = ?", [$email]);

        if ($user === null) {
            return null;
        }

        if (password_verify($password, $user->password)) {
            return $user;
        }

        return null;
    }
}