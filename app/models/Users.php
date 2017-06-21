<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Relation;


class Users extends Model
{


    public $id;

    public $name;

    public $about;

    public $email;

    public $password;


    public function initialize()
    {
        $this->hasMany(
            "id",
            "Robots",
            "users_id",
            [
                "foreignKey" => [
                    "action" => Relation::ACTION_CASCADE,
                ]
            ]
        );
    }
}