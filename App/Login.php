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
        $this->db = Database::getInstance();

        return $this;
    }

    public function setUsernameAndPassword($username, $password)
    {
        $this->username = trim($username);
        $this->password = trim($password);
    }

    public function verify()
    {
        $sql = "SELECT * FROM users WHERE username = ?";

        $result = $this->db->query($sql, 's', $this->username);

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

        return (empty($this->errors)) ? true : false;
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
        return (array_key_exists($value, $this->errors)) ? true : false;
    }

    public function first($value)
    {
        return $this->errors[$value][0];
    }

    private function verifyUser($obj)
    {
        return ($obj->username == $this->username && password_verify($this->password, $obj->password)) ? true : false;
    }
}
