<?php

namespace app\Models;

use framework\Model;

class Person extends Model
{
    // name TEXT
    // age INTEGER

    protected static $table = "people";

    public function cars()
    {
        return $this->has_many(Car::class, "id_person");
    }
}
