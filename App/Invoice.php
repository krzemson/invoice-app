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
    public $invtype = "FV-";

    public function setInvNum()
    {
        $sql = "SELECT MAX(id) FROM invoices";

        $stmt = self::$db->query($sql);

        $result = $stmt->fetch_array();

        $date = (new DateTime())->format("Y");

        $number = $result[0]+1;

        $invnum = $this->invtype. $number."/".$date;

        $this->invnum = $invnum;
    }

    public function setPayment($payment)
    {
        $payments = [
            '7' => 'Przelew - 7 dni',
            '14' => 'Przelew - 14 dni',
            'cash' => 'Gotówka',
            'card' => 'Płatność kartą',
        ];

        $date = new DateTime($this->date_issue);

        if ($payment == 7 || $payment == 14) {
            $this->payment = $payments[$payment];
            $interval = "P".$payment."D";

            $date->add(new \DateInterval($interval));

            $this->term_payment = $date->format('Y-m-d');
        } else {
            $this->payment = $payments[$payment];
            $this->term_payment = $date->format('Y-m-d');
        }
    }

    public function insertId()
    {
        return self::$db->insertId();
    }

    public static function findAllInvoices($id)
    {
        static::$db = Database::getInstance();

        $sql = "SELECT * FROM ". self::$table ." WHERE user_id = $id";

        $result = self::$db->query($sql);

        $rows = $result->fetch_all(MYSQLI_ASSOC);

        if ($rows == null)
            return false;

        $objectsArray = [];

        foreach ($rows as $row) {
            $objectsArray[] = static::instance($row);
        }

        return $objectsArray;
    }

    public function customer()
    {
        $sql = "SELECT * FROM customers WHERE id = $this->customer_id";

        $row = self::$db->query($sql);

        $result = $row->fetch_object();

        return $result;
    }

    public function profile()
    {
        $sql = "SELECT * FROM users WHERE id = $this->user_id";

        $row = self::$db->query($sql);

        $result = $row->fetch_object();

        return $result;
    }

    public function services()
    {
        $sql = "SELECT * FROM services WHERE invoice_id = $this->id";

        $result = self::$db->query($sql);

        $rows = $result->fetch_all(MYSQLI_ASSOC);

        $objectsArray = [];

        foreach ($rows as $row) {
            $objectsArray[] = static::instance($row);
        }

        return $objectsArray;
    }

    public static function deleteInvoice($id)
    {
        static::$db = Database::getInstance();

        $sql = "DELETE FROM invoices WHERE id = $id";

        return self::$db->query($sql);

    }

}