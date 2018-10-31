<?php
/**
 * Created by PhpStorm.
 * User: Jakub
 * Date: 30.10.2018
 * Time: 19:50
 */

namespace App;

class User
{
    protected $id;
    protected $username;
    protected $password;
    protected $db;

    public function __construct()
    {
        $this->db = new Database();
    }

}
