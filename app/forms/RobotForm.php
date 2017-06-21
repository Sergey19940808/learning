<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Numeric;
use Phalcon\Forms\Element\Select;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Uniqueness;


class RobotForm extends Form
{
    public function initialize()
    {

        $name = new Text(
            "name",
            [
                "maxlength" => 30,
                "placeholder" => "Введите имя робота",
                "class" => "form-control"
            ]
        );
        $name->setLabel("Имя робота");

        $name->setFilters(
            [
                "string",
                "trim",
            ]
        );

        $name->addValidators([
            new PresenceOf([
                "message" => "Имя робота не должно быть пустым"
            ])
        ]);


        $this->add($name);


        $type = new Select(
            "type",
            [
                "virtual" => "virtual",
                "real" => "real",
                "intelect" => "intelect"
            ]
        );
        $type->setLabel("Тип робота");

        $this->add($type);



        $year = new Numeric(
            "year",
            [
                "maxlength" => 30,
                "placeholder" => "Введите год создания робота",
                "class" => "form-control"
            ]
        );
        $year->setLabel("Год создания");

        $this->add($year);



    }

}