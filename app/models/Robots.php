<?php


use Phalcon\Mvc\Model;

class Robots extends Model

{
    public $id;

    public $name;

    public $type;

    public $year;

    public $users_id;

    public function initialize()
    {
        $this->belongsTo(
            "users_id",
            "Users",
            "id"
        );
    }


}