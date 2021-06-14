<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class PasswordReset
 * @package App\Models
 */
class PasswordReset extends Model
{
    public $timestamps = false;
    protected $fillable = ['email', 'token'];
}