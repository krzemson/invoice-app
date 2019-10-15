<?php
/**
 * Created by PhpStorm.
 * User: krzemson
 * Date: 14.10.2019
 * Time: 01:12
 */

namespace App;


class Register
{
    private $username;
    private $password;
    private $email;
    private $name;
    private $surname;
    public $errors = [];

    public function setDataRegister($username, $password, $email, $name, $surname)
    {
        $this->username = trim($username);
        $this->password = trim($password);
        $this->email = trim($email);
        $this->name = trim($name);
        $this->surname = trim($surname);
    }

    public function validate()
    {
        if (!preg_match('/^[a-ząćęłńóśźżA-ZZĘÓĄŚŁŻŹĆŃ]+$/', $this->username)) {
            $this->errors["username"][] = 'Login nieprawidłowy, może zawierać tylko litery';
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->errors["email"][] = "Adres email jest niepoprawny";
        }  elseif (!preg_match('/^[a-ząćęłńóśźżA-Z]+$/', $this->name)) {
            $this->errors["name"][] = 'Imię jest nieprawidłowe, może zawierać tylko litery';
        } elseif (!preg_match('/^[a-ząćęłńóśźżA-ZZĘÓĄŚŁŻŹĆŃ]+$/', $this->surname)) {
            $this->errors["surname"][] = 'Nazwisko nieprawidłowe, może zawierać tylko litery';
        } elseif (!preg_match('/^[a-ząćęłńóśźżA-ZZĘÓĄŚŁŻŹĆŃ0-9]+$/', $this->password)) {
            $this->errors["password"][] = 'Hasło nieprawidłowe, może zawierać tylko litery';
        }

        return (empty($this->errors)) ? true : false;
    }

    public function register()
    {
        $user = new User();

        $user->username = $this->username;
        $user->password = password_hash($this->password, PASSWORD_DEFAULT);
        $user->name = $this->name;
        $user->surname = $this->surname;
        $user->email = $this->email;

        $user->save();

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