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

        return [];
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

        return null;
    }

    public function delete(): int
    {
        $this->sql = "DELETE FROM $this->sqltable";
        if (isset($this->where))
            $this->sql .= " where $this->where";

        $db = ConnectionFactory::getConnection();
        $statement = $db->prepare($this->sql);

        if ($statement->execute($this->args))
            return $statement->rowCount();

        return -1;
    }

    public function insert(array $data): int
    {
        $columns = [];
        $prepared = [];
        $values = [];


        foreach ($data as $key => $value) {
            $columns[] = $key;
            $prepared[] = "?";
            $values[] = $value;
        }

        $columns = implode(', ', $columns);
        $prepared = implode(', ', $prepared);

        $this->sql = "INSERT INTO $this->sqltable($columns) VALUES($prepared)";

        $db = ConnectionFactory::getConnection();
        $statement = $db->prepare($this->sql);

        if ($statement->execute($values))
            return $db->lastInsertId();

        return -1;
    }

    public function update(array $data): int
    {
        $columns = [];
        $values = [];

        foreach ($data as $key => $value) {
            $columns[] = "$key = ?";
            $values[] = $value;
        }

        $columns = implode(', ', $columns);

        $this->sql = "UPDATE $this->sqltable SET $columns";

        if (isset($this->where)) {
            $this->sql .= " WHERE $this->where;";
            $values = array_merge($values, $this->args);
        }

        $db = ConnectionFactory::getConnection();
        $statement = $db->prepare($this->sql);

        if ($statement->execute($values))
            return $statement->rowCount();

        return -1;
    }
}
