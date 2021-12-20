<?php

namespace framework;

use framework\utils\Query;

abstract class Model
{
    protected static $table;
    protected static $primaryKey = 'id';

    private $_attributes = [];

    public static function getTableName(): string
    {
        return static::$table;
    }

    public static function getPrimaryKey(): string
    {
        return static::$primaryKey;
    } 

    public function __get($name)
    {
        if (array_key_exists($name, $this->_attributes))
            return $this->_attributes[$name];

        if (method_exists($this, $name))
            return $this->$name();

        return null;
    }

    public function __set($name, $value)
    {
        $this->_attributes[$name] = $value;
    }

    public function __construct(array $attributes = null)
    {
        if (!is_null($attributes))
            $this->_attributes = $attributes;
    }

    public function delete(): int
    {
        return Query::table(static::$table)->where([[static::$primaryKey, "=", $this->_attributes[static::$primaryKey]]])->delete();
    }

    public function insert(): int
    {
        return $this->id = Query::table(static::$table)->insert($this->_attributes);
    }

    public static function all(): array
    {
        $data = Query::table(static::$table)->select()->get();

        $objects = [];
        foreach ($data as $object) {
            $objects[] = new static((array)$object);
        }

        return $objects;
    }

    public static function find($where, array $fields = null): array
    {
        if (!is_array($where))
            $data = Query::table(static::$table)->select($fields)->where([[static::$primaryKey, "=", $where]])->get();
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
            $data = Query::table(static::$table)->select($fields)->where([[static::$primaryKey, "=", $where]])->one();
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

            $foreign_data = Query::table($class::$table)->select()->where([[static::$primaryKey, "=", $this->$foreign_key]])->one();

            $class = new $class_name((array) $foreign_data);
        }
        return $class;
    }

    public function has_many(string $class_name, string $foreign_key): array
    {
        $class_name = __NAMESPACE__ . '\\' . $class_name;
        $class = new $class_name();

        $foreign_data = Query::table($class::$table)->select()->where([[$foreign_key, "=", $this->_attributes[static::$primaryKey]]])->get();

        $objects = [];
        foreach ($foreign_data as $object) {
            $objects[] = new $class_name((array)$object);
        }

        return $objects;
    }

    public function getData(): array
    {
        return $this->_attributes;
    }

    public function update(): int
    {
        return Query::table(static::$table)
            ->where([[static::$primaryKey, "=", $this->_attributes[static::$primaryKey]]])
            ->update($this->_attributes);
    
    }
}
