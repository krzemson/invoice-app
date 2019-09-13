<?php

namespace App;

class API
{
    private $invoice;
    private $user;

    public function __construct()
    {
        $this->user = new Login();
        $this->invoice = new Invoice();
    }

    public function login($username, $password)
    {
        $this->user->setUsernameAndPassword($username, $password);
    }

    public function validate()
    {
        return $this->user->validate();
    }

    public function verify()
    {
        return $this->user->verify();
    }

}
