<?php


use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;


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

    public function validation()
    {
        $validator = new Validation;

        $validator->add(
            "name",
            new Uniqueness(
                [
                    "message" => "Название робота должно быть уникальным",
                ]
            )
        );

        return $this->validate($validator);

    }


}