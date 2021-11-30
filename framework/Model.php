<?php

namespace framework;

use framework\utils\Query;

abstract class Model
{
    protected static $table;
    protected static $idColumn = 'id';

    private $_attributs = [];

    public function __get($name)
    {
        if (array_key_exists($name, $this->_attributs))
            return $this->_attributs[$name];

        if (method_exists($this, $name))
            return $this->$name();
    }

    public function __set($name, $value)
    {
        $this->_attributs[$name] = $value;
    }

    public function __construct(array $attributs = null)
    {
        if (!is_null($attributs))
            $this->_attributs = $attributs;
    }

    public function delete()
    {
        return Query::table(static::$table)->where([[static::$idColumn, "=", $this->_attributs[static::$idColumn]]])->delete();
    }

    public function insert()
    {
        return $this->id = Query::table(static::$table)->insert($this->_attributs);
    }

    public static function all()
    {
        $data = Query::table(static::$table)->select()->get();

        $objects = [];
        foreach ($data as $object) {
            $objects[] = new static((array)$object);
        }

        return $objects;
    }

    public static function find($where, array $fields = null)
    {
        if (!is_array($where))
            $data = Query::table(static::$table)->select($fields)->where([[static::$idColumn, "=", $where]])->get();
        else {
            if (is_array($where[0]))
                $data = Query::table(static::$table)->select($fields)->where($where)->get();
            else
                $data = Query::table(static::$table)->select($fields)->where([$where])->get();
        }

        $objects = [];
        foreach ($data as $object) {
            $objects[] = new static((array)$object);
        }

        return $objects;
    }

    public static function first($where, array $fields = null)
    {
        if (!is_array($where))
            $data = Query::table(static::$table)->select($fields)->where([[static::$idColumn, "=", $where]])->one();
        else {
            if (is_array($where[0]))
                $data = Query::table(static::$table)->select($fields)->where($where)->one();
            else
                $data = Query::table(static::$table)->select($fields)->where([$where])->one();
        }

        if ($data)
            return new static((array) $data);

        return null;
    }

    public function belongs_to(string $class_name, string $foreign_key)
    {
        if (!is_null($this->$foreign_key)) {
            $class_name = __NAMESPACE__ . '\\' . $class_name;
            $class = new $class_name();

            $foreign_data = Query::table($class::$table)->select()->where([[static::$idColumn, "=", $this->$foreign_key]])->one();

            $class = new $class_name((array) $foreign_data);
        }
        return $class;
    }

    public function has_many(string $class_name, string $foreign_key)
    {
        $class_name = __NAMESPACE__ . '\\' . $class_name;
        $class = new $class_name();

        $foreign_data = Query::table($class::$table)->select()->where([[$foreign_key, "=", $this->_attributs[static::$idColumn]]])->get();

        $objects = [];
        foreach ($foreign_data as $object) {
            $objects[] = new $class_name((array)$object);
        }

        return $objects;
    }

    public function getData()
    {
        return $this->_attributs;
    }
}
