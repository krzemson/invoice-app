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

    public function validate()
    {

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->errors["email"][] = "Adres email jest niepoprawny";
        } elseif (!preg_match('/^[a-ząćęłńóśźżA-Z]+$/', $this->name)) {
            $this->errors["name"][] = 'Imię jest nieprawidłowe, może zawierać tylko litery';
        } elseif (!preg_match('/^[a-ząćęłńóśźżA-ZZĘÓĄŚŁŻŹĆŃ]+$/', $this->surname)) {
            $this->errors["surname"][]  = 'Nazwisko nieprawidłowe, może zawierać tylko litery';
        } elseif (strlen($this->nip) != 10 || !preg_match('/^[0-9]+$/', $this->nip)) {
            $this->errors["nip"][] = 'NIP jest nieprawidłowy. Powinien składać się z dziesięciu cyfr';
        } elseif (strlen($this->regon) != 9 || !preg_match('/^[0-9]+$/', $this->regon)) {
            $this->errors["regon"][] = 'REGON jest nieprawidłowy. Powinien składać się z dziewięciu cyfr';
        } elseif (!preg_match('/^[a-ząćęłńóśźżA-ZĘÓĄŚŁŻŹĆŃ0-9\/\s]+$/', $this->address)) {
            $this->errors["address"][] = 'Wprowadzony adres jest nieprawidłowy';
        } elseif (!preg_match('/^[a-ząćęłńóśźżA-ZĘÓĄŚŁŻŹĆŃ0-9\s]+$/', $this->company)) {
            $this->errors["company"][] = 'Wprowadzona nazwa firmy jest nieprawidłowa';
        } elseif (!preg_match('/^[a-ząćęłńóśźżA-ZĘÓĄŚŁŻŹĆŃ0-9\s]+$/', $this->city)) {
            $this->errors["city"][] = 'Wprowadzone miasto jest nieprawidłowe';
        }

        return (empty($this->errors)) ? true : false;
    }

    public function has($value)
    {
        return (array_key_exists($value, $this->errors)) ? true : false;
    }

    public function first($value)
    {
        return $this->errors[$value][0];
    }
}
