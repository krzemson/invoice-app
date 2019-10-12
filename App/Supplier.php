<?php
/**
 * Created by PhpStorm.
 * User: krzemson
 * Date: 06.10.2019
 * Time: 22:57
 */

namespace App;


class Supplier extends Model
{
    protected static $table = "suppliers";
    protected $fillable = ['user_id', 'company', 'address', 'city', 'nip', 'regon'];
    public $id;
    public $user_id;
    public $company;
    public $address;
    public $city;
    public $nip;
    public $regon;
    public $errors = [];

    public static function findAllSuppliers($id)
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

    public static function deleteSupplier($id)
    {
        $sql = "DELETE FROM suppliers WHERE id = $id";

        self::$db->query($sql);

        return true;
    }

    public function validate()
    {

        if (strlen($this->nip) != 10 || !preg_match('/^[0-9]+$/', $this->nip)) {
            $this->errors["nip"][] = 'NIP jest nieprawidłowy. Powinien składać się z dziesięciu cyfr';
        } elseif (strlen($this->regon) != 9 || !preg_match('/^[0-9]+$/', $this->regon)) {
            $this->errors["regon"][] = 'REGON jest nieprawidłowy. Powinien składać się z dziewięciu cyfr';
        } elseif (!preg_match('/^[a-ząćęłńóśźżA-ZĘÓĄŚŁŻŹĆŃ0-9\/\s]+$/', $this->address)) {
            $this->errors["address"][] = 'Wprowadzony adres jest nieprawidłowy';
        } elseif (!preg_match('/^[a-ząćęłńóśźżA-ZĘÓĄŚŁŻŹĆŃ0-9\s]+$/', $this->company)) {
            $this->errors["company"][] = 'Wprowadzona nazwa firmy jest nieprawidłowa';
        } elseif (!preg_match('/^[a-ząćęłńóśźżA-ZĘÓĄŚŁŻŹĆŃ0-9\s]+$/', $this->city)) {
            $this->errors["city"][] = 'Wprowadzone miasto jest nieprawidłowe';
        }

        return (empty($this->errors)) ? true : false;
    }

    public function has($value)
    {
        return (array_key_exists($value, $this->errors)) ? true : false;
    }

    public function first($value)
    {
        return $this->errors[$value][0];
    }
}