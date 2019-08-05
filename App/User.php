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
    protected $fillable = ['username', 'name', 'surname', 'company', 'address', 'city', 'nip', 'regon', 'email', 'password'];
    public $id;
    public $username;
    public $name;
    public $surname;
    public $company;
    public $address;
    public $city;
    public $nip;
    public $regon;
    public $email;
    public $password;
    public $errors = [];

    public function validate($name, $surname, $company, $address, $city, $nip, $regon, $email, $password)
    {

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors["email"] = "Adres email jest niepoprawny";
        } elseif (!preg_match('/^[a-zA-Z]+$/', $name)) {
            $this->errors["name"]  = 'Imię jest nieprawidłowe, może zawierać tylko litery';
        } elseif (!preg_match('/^[a-zA-Z]+$/', $surname)) {
            $this->errors["surname"]  = 'Nazwisko nieprawidłowe, może zawierać tylko litery';
        } elseif (strlen($password) < 6) {
            $this->errors["password"] = 'Hasło jest za krótkie';
        } elseif (!(strlen($nip) == 10) & !preg_match('/^[0-9]+$/', $nip)) {
            $this->errors["nip"] = 'NIP jest nieprawidłowy. Powinien składać się z dziesięciu cyfr';
        } elseif (!(strlen($nip) == 9) & !preg_match('/^[0-9]+$/', $regon)) {
            $this->errors["regon"] = 'NIP jest nieprawidłowy. Powinien składać się z dziesięciu cyfr';
        } elseif (!preg_match('/^[a-zA-Z0-9\s]+$/', $address)) {
            $this->errors["address"] = 'Wprowadzony adres jest nieprawidłowy';
        } elseif (!preg_match('/^[a-zA-Z0-9\s]+$/', $company)) {
            $this->errors["company"] = 'Wprowadzona nazwa firmy jest nieprawidłowa';
        } elseif (!preg_match('/^[a-zA-Z0-9\s]+$/', $city)) {
            $this->errors["address"] = 'Wprowadzony adres jest nieprawidłowy';
        }

        return (empty($this->errors)) ? true : false;
    }
}
