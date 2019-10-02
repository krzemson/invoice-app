<?php
/**
 * Created by PhpStorm.
 * User: krzemson
 * Date: 14.11.2018
 * Time: 18:22
 */

namespace App;


class Service extends Model
{
    protected static $table = "services";
    protected $fillable = ['invoice_id', 'service', 'quantity', 'unit', 'net', 'netv', 'tax', 'taxv', 'gross'];

    public $id;
    public $invoice_id;
    public $service;
    public $quantity;
    public $unit;
    public $net;
    public $netv;
    public $tax;
    public $taxv;
    public $gross;

    public function setNetValue()
    {
        $this->netv = bcmul($this->quantity, $this->net, 2);
    }

    public function setTaxValue()
    {
        $this->taxv = bcmul($this->netv, $this->tax, 2);
    }

    public function setGrossValue()
    {
        $this->gross = bcadd($this->netv, $this->taxv, 2);
    }

    public static function findAllServicesForAllUserServices($user_id)
    {
        static::$db = Database::getInstance();

        $sql = "SELECT * FROM ". self::$table ." WHERE invoice_id in (SELECT id FROM invoices WHERE user_id = $user_id)";

        $result = self::$db->query($sql);

        $rows = $result->fetch_all(MYSQLI_ASSOC);

        //if ($rows == null)
            //return false;

        $objectsArray = [];

        foreach ($rows as $row) {
            $objectsArray[] = static::instance($row);
        }

        return $objectsArray;
    }
}