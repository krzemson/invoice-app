<?php
/**
 * Created by PhpStorm.
 * User: Jakub
 * Date: 30.10.2018
 * Time: 15:40
 */

namespace App;

class Database
{
    protected $db;

    public function __construct()
    {
        $this->db = new \mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($this->db->connect_errno) {
            die("Database connection failed ".$this->db->connect_errno);
        }
    }

    public function query($sql)
    {
        $result = $this->db->query($sql);

        $this->confirm($result);

        return $result;
    }

    private function confirm($result)
    {
        if (!$result) {
            die("QUERY FAILED ".$this->db->error);
        }

        return true;
    }
}
