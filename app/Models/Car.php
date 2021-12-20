<?php

namespace app\Models;

use framework\Model;

class Car extends Model
{
    // matricule TEXT
    // brand TEXT
    // model INTEGER
    // id_person INTEGER
    // CONSTRAINT fk_people FOREIGN KEY (id_person) REFERENCES people (id)

    protected static $table = "cars";
    protected static $primaryKey = "matricule";

    public function person()
    {
        return $this->belongs_to(Person::class, "id");
    }
}
