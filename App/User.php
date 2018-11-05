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
    public $username;
    protected $db;

    public function __construct($id = null)
    {
        $this->db = new Database();

        if (!isset($this->id)) {
            $this->findById($id);
        }
    }

    private function findById($id)
    {
        $sql = "SELECT * FROM users WHERE id = $id";

        $result = $this->db->query($sql);

        $row = $result->fetch_assoc();

        $this->id = $row['id'];
        $this->username = $row['username'];
    }
}
