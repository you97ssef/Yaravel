<?php

namespace framework\utils;

use PDO;

class Query
{
    private $sqltable;
    private $fields = '*';
    private $where = null;
    private $args = [];
    private $sql = '';


    public static function table(string $table): Query
    {
        $query = new Query;
        $query->sqltable = $table;
        return $query;
    }

    public function select(array $fields = null): Query
    {
        if (isset($fields))
            $this->fields = implode(', ', $fields);

        return $this;
    }

    /*public function where(string $col, string $op, $val): Query
    {
        if (isset($this->where))
            $this->where .= " and $col $op ?";
        else
            $this->where = "$col $op ?";
        $this->args[] = $val;
        return $this;
    }*/

    public function where(array $conditions): Query
    {
        foreach ($conditions as $condition) {
            if (isset($this->where))
                $this->where .= " and $condition[0] $condition[1] ?";
            else
                $this->where = "$condition[0] $condition[1] ?";
            $this->args[] = $condition[2];
        }

        return $this;
    }

    public function orWhere(string $col, string $op, $val): Query
    {
        if (isset($this->where))
            $this->where .= " or $col $op ?";
        else
            $this->where = "$col $op ?";
        $this->args[] = $val;
        return $this;
    }

    public function get(): array
    {
        $this->sql = 'select ' . $this->fields .
            ' from ' . $this->sqltable;

        if (isset($this->where)) {
            $this->sql .= " where $this->where";
        }

        $db = ConnectionFactory::getConnection();
        $statement = $db->prepare($this->sql);

        if ($statement->execute($this->args))
            return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    public function one()
    {
        $this->sql = 'select' . $this->fields .
            ' from ' . $this->sqltable;

        if (isset($this->where)) {
            $this->sql .= " where $this->where";
        }

        $this->sql .= " LIMIT 1";

        $db = ConnectionFactory::getConnection();
        $statement = $db->prepare($this->sql);

        if ($statement->execute($this->args))
            return $statement->fetch(PDO::FETCH_OBJ);
    }

    public function delete()
    {
        $this->sql = "delete from $this->sqltable";
        if (isset($this->where))
            $this->sql .= " where $this->where";

        $db = ConnectionFactory::getConnection();
        $statement = $db->prepare($this->sql);

        if ($statement->execute($this->args))
            return $statement->rowCount();
    }

    public function insert(array $data)
    {
        $colonnes = [];
        $values = [];

        foreach ($data as $key => $value) {
            array_push($colonnes, $key);
            array_push($values, "?");
            $this->args[] = $value;
        }

        $colonnes = implode(', ', $colonnes);
        $values = implode(', ', $values);

        $this->sql = "insert into $this->sqltable($colonnes) values($values)";

        $db = ConnectionFactory::getConnection();
        $statement = $db->prepare($this->sql);

        if ($statement->execute($this->args))
            return $db->lastInsertId();
    }
}
