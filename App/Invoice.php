<?php


namespace App;


use DateTime;

class Invoice extends Model
{
    protected static $table = 'invoices';
    protected $fillable = ['user_id', 'customer_id', 'invnum', 'net_value', 'tax_value', 'gross_value', 'payment', 'term_payment', 'inwords', 'date_issue', 'date_service'];

    public $id;
    public $user_id;
    public $customer_id;
    public $invnum;
    public $net_value;
    public $tax_value;
    public $gross_value;
    public $payment;
    public $term_payment;
    public $inwords;
    public $date_issue;
    public $date_service;

    public function setInvNum ()
    {
        $sql = "SELECT MAX(id) FROM invoices";

        $stmt = self::$db->query($sql);

        $result = $stmt->fetch_array();

        $date = (new DateTime())->format("Y");

        $number = $result[0]+1;

        $invnum = "FV-". $number."/".$date;

        $this->invnum = $invnum;

    }

    public function insertId()
    {
        return self::$db->insertId();
    }

}