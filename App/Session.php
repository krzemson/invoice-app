<?php
/**
 * Created by PhpStorm.
 * User: Jakub
 * Date: 02.11.2018
 * Time: 18:03
 */

namespace App;

class Session
{
    private $signedIn = false;
    protected $userId;

    public function __construct()
    {
        session_start();
        $this->checkLogin();
    }

    public function isSigned()
    {
        return $this->signedIn;
    }

    public function login($user)
    {
        $this->userId = $_SESSION['userId'] = $user->id;
        $this->signedIn = true;
    }

    private function checkLogin()
    {
        if (isset($_SESSION['userId'])) {
            $this->userId = $_SESSION['userId'];
            $this->signedIn = true;
        } else {
            unset($this->userId);
            $this->signedIn = false;
        }
    }

    public function user()
    {

        return User::findById($this->userId);
    }

    public function logout()
    {
        unset($_SESSION['userId']);
        unset($this->userId);
        $this->signedIn = false;
    }
}