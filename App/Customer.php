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
    protected $table = "customers";
    protected $fillable = ['name', 'surname', 'company', 'address', 'city', 'nip', 'regon'];
    protected $id;
    public $name;
    public $surname;
    public $company;
    public $address;
    public $city;
    public $nip;
    public $regon;

    public function findAllCustomers($id)
    {
        $sql = "SELECT * FROM $this->table WHERE user_id = $id";

        $result = $this->db->query($sql);

        $rows = $result->fetch_all(MYSQLI_ASSOC);

        $objectsArray = [];

        foreach ($rows as $row) {
            $objectsArray[] = $this->instance($row);
        }

        return $objectsArray;
    }
}