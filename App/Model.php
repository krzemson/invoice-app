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
    protected $table;
    protected $fillable;
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();

        return $this;
    }

    public function findById($id)
    {
        $sql = "SELECT * FROM $this->table WHERE id = ?";

        $result = $this->db->query($sql, 'i', $id);

        $row = $result->fetch_assoc();

        foreach ($row as $attribute => $value) {
            $this->$attribute = $value;
        }

        return $this;
    }

    public function findAll()
    {
        $sql = "SELECT * FROM $this->table";

        $result = $this->db->query($sql);

        $rows = $result->fetch_all(MYSQLI_ASSOC);

        $objectsArray = [];

        foreach ($rows as $row) {
            $objectsArray[] = $this->instance($row);
        }

        return $objectsArray;
    }

    protected function instance($row)
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
            if (filter_var($params[$i], FILTER_VALIDATE_INT) === true) {
                $types[] = "i";
            } else {
                $types[] = "s";
            }

            $signs[] = "?";
        }

        $types = implode("", $types);

        $sql = "INSERT INTO $this->table (".implode(", ", array_keys($properties)).")";
        $sql .= " VALUES (".implode(", ", $signs).")";



        $this->db->query($sql, $types, $params);

        return true;
    }

    protected function update()
    {
        $properties = $this->properties();

        $propertiesPairs = [];

        foreach ($properties as $key => $value) {
            $propertiesPairs[] = "$key = ?";
        }

        $sql = "UPDATE  " .$this->table . "  SET ";
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

        $this->db->query($sql, $types, $params);

        return true;
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
