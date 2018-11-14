<?php
/**
 * Created by PhpStorm.
 * User: Jakub
 * Date: 30.10.2018
 * Time: 19:50
 */

namespace App;

class User extends Model
{
    protected static $table = "users";
    protected $fillable = ['username', 'name', 'surname', 'email', 'password'];
    public $id;
    public $username;
    public $name;
    public $surname;
    public $email;
    public $password;
}
