<?php
/**
 * Created by PhpStorm.
 * User: Jakub
 * Date: 30.10.2018
 * Time: 20:25
 */

namespace App;

class Login
{
    private $username;
    private $password;
    protected $db;
    public $errors = [];

    public function __construct()
    {
        $this->db = new Database();

        return $this;
    }

    public function setUsernameAndPassword($username, $password)
    {
        $this->username = trim($username);
        $this->password = trim($password);
    }

    public function verify()
    {
        $sql = "SELECT * FROM users WHERE username = '$this->username'";

        $result = $this->db->query($sql);

        $obj = $result->fetch_object();

        if ($result->num_rows > 0 && $this->verifyUser($obj)) {
            return $obj;
        } else {
            $this->errors['verify'][] = 'Podano niewłaściwy login lub hasło';
        }

        return false;
    }

    public function validate()
    {
        $this->checkIfFieldsAreEmpty();

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }

    private function checkIfFieldsAreEmpty()
    {
        if (empty($this->username) && empty($this->password)) {
            $this->errors['username'][] = 'Pole użytkownik nie może być puste';
            $this->errors['password'][] = 'Pole hasło nie może być puste';
        } elseif (empty($this->username)) {
            $this->errors['username'][] = 'Pole użytkownik nie może być puste';
        } elseif (empty($this->password)) {
            $this->errors['password'][] = 'Pole hasło nie może być puste';
        }
    }

    public function has($value)
    {
        if (array_key_exists($value, $this->errors)) {
            return true;
        }
        return false;
    }

    public function first($value)
    {
        return $this->errors[$value][0];
    }

    private function verifyUser($obj)
    {
        if ($obj->username == $this->username && $obj->password == $this->password) {
            return true;
        }
        return false;
    }
}
