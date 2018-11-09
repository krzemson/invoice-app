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
    private static $instance;
    public $db;

    private function __construct()
    {
        $this->db = new \mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $this->db->set_charset("utf8");

        if ($this->db->connect_errno) {
            die("Database connection failed ".$this->db->connect_errno);
        }
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    public function query($sql, $type = "", $values = "")
    {
        $stmt = $this->db->prepare($sql);

        if (is_array($values)) {
            $stmt->bind_param($type, ...$values);
        } else {
            !(empty($type) || empty($values)) ? $stmt->bind_param($type, $values) : null;
        }

        $this->confirm($stmt->execute());

        $result = $stmt->get_result();

        $stmt->close();

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
