<?php
/**
 * Created by PhpStorm.
 * User: Jakub
 * Date: 06.11.2018
 * Time: 12:21
 */

namespace App;

class Customer extends Model
{
    protected static $table = "customers";
    protected $fillable = ['user_id','name', 'surname', 'company', 'address', 'city', 'nip', 'regon'];
    public $id;
    public $user_id;
    public $name;
    public $surname;
    public $company;
    public $address;
    public $city;
    public $nip;
    public $regon;

    public static function findAllCustomers($id)
    {
        $sql = "SELECT * FROM ". self::$table ." WHERE user_id = $id";

        $result = self::$db->query($sql);

        $rows = $result->fetch_all(MYSQLI_ASSOC);

        $objectsArray = [];

        foreach ($rows as $row) {
            $objectsArray[] = static::instance($row);
        }

        return $objectsArray;
    }
}