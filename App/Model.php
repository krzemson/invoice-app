<?php
/**
 * Created by PhpStorm.
 * User: Jakub
 * Date: 06.11.2018
 * Time: 18:22
 */

namespace App;

abstract class Model
{
    protected static $table;
    protected $fillable;
    protected static $db;

    public function __construct()
    {
        static::$db = Database::getInstance();

        return $this;
    }

    public static function findById($id)
    {
        static::$db = Database::getInstance();

        $sql = "SELECT * FROM ". static::$table ." WHERE id = ?";


        $result = static::$db->query($sql, 'i', $id);


        $row = $result->fetch_assoc();

        if ($row == null)
            return false;

        $class = get_called_class();

        $object = new $class;

        foreach ($row as $attribute => $value) {
            $object->$attribute = $value;
        }

        return $object;
    }

    public static function findAll()
    {
        static::$db = Database::getInstance();

        $sql = "SELECT * FROM ". static::$table;

        $result = static::$db->query($sql);

        $rows = $result->fetch_all(MYSQLI_ASSOC);

        if ($rows == null)
            return false;

        $objectsArray = [];

        foreach ($rows as $row) {
            $objectsArray[] = static::instance($row);
        }

        return $objectsArray;
    }

    protected static function instance($row)
    {

        $class = get_called_class();

        $object = new $class;

        foreach ($row as $attribute => $value) {
            $object->$attribute = $value;
        }

        return $object;
    }

    public function save()
    {
        return isset($this->id) ? $this->update() : $this->create();
    }

    protected function create()
    {
        $properties = $this->properties();

        $types = [];
        $signs = [];

        $params = array_values($properties);

        for ($i = 0; $i < count($params); $i++) {
            if (filter_var($params[$i], FILTER_VALIDATE_INT) === false) {
                $types[] = "s";
            } else {
                $types[] = "i";
            }

            $signs[] = "?";
        }

        $types = implode("", $types);

        $sql = "INSERT INTO ". static::$table ." (".implode(", ", array_keys($properties)).")";
        $sql .= " VALUES (".implode(", ", $signs).")";

        return static::$db->query($sql, $types, $params);
    }

    protected function update()
    {
        $properties = $this->properties();

        $propertiesPairs = [];

        foreach ($properties as $key => $value) {
            $propertiesPairs[] = "$key = ?";
        }

        $sql = "UPDATE  " .static::$table . "  SET ";
        $sql .= implode(", ", $propertiesPairs);
        $sql .= " WHERE id= $this->id";

        $params = array_values($properties);

        $types = [];

        for ($i = 0; $i < count($params); $i++) {
            if (filter_var($params[$i], FILTER_VALIDATE_INT) === true) {
                $types[] = "i";
            } else {
                $types[] = "s";
            }
        }

        $types = implode("", $types);

        return static::$db->query($sql, $types, $params);
    }

    protected function properties()
    {
        $properties = [];

        foreach ($this->fillable as $field) {
            $properties[$field] = $this->$field;
        }

        return $properties;
    }
}
