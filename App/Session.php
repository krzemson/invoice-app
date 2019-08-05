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

    public function flash($status, $msg)
    {
        $_SESSION[$status] = $msg;

    }

    public function get($name)
    {
        if (isset($_SESSION[$name])) {
            $message = $_SESSION[$name];
            unset($_SESSION[$name]);

            return $message;
        }
        return null;
    }

    public function rememberMe()
    {
        $encryptCookieData = base64_encode("USKXJjdso92dsSd82mdSm32M{$this->userId}");

        setcookie("rememberUserCookie", $encryptCookieData, time()+60*60*24*30, "/");
    }

    public function isCookieValid()
    {

        if (isset($_COOKIE['rememberUserCookie'])) {
            $decryptCookieData = base64_decode($_COOKIE['rememberUserCookie']);

            $split = explode("USKXJjdso92dsSd82mdSm32M", $decryptCookieData);

            $userId = $split[1];

            $this->userId = $_SESSION['userId'] = $userId;
            $this->signedIn = true;
        }

    }

    public function logout()
    {
        unset($_SESSION['userId']);
        unset($this->userId);
        if (isset($_COOKIE['rememberUserCookie'])) {
            unset($_COOKIE['rememberUserCookie']);
            setcookie('rememberUserCookie',null, -1, "/");
        }
        $this->signedIn = false;
        redirect("../index.php");
    }
}