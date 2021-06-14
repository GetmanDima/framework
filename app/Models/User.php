<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @package App\Models
 */
class User extends Model
{
    protected $fillable = ['name', 'email', 'password', 'remember_token'];

    /**
     * @param array $attributes
     * @return Model
     */
    public static function register(array $attributes = []): Model
    {
        $attributesWithPasswordHash = $attributes;
        $attributesWithPasswordHash['password'] = password_hash($attributes['password'], PASSWORD_BCRYPT);

        return static::create($attributesWithPasswordHash);
    }

    /**
     * @param $email
     * @param $password
     * @return Model|null
     */
    public static function login($email, $password): ?Model
    {
        $user = static::where('email', $email)->first();

        if ($user !== null) {
            if (password_verify($password, $user->password)) {
                return $user;
            }
        }

        return null;
    }
}