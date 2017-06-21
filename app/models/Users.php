<?php

use Phalcon\Mvc\Model;


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
            "users_id"
        );
    }
}