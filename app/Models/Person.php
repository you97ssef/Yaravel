<?php

namespace app\Models;

use framework\Model;

class Person extends Model
{
    // name TEXT
    // age INTEGER
    // role TEXT

    protected static $table = "people";

    public function cars()
    {
        return $this->has_many(Car::class, "id_person");
    }
}
