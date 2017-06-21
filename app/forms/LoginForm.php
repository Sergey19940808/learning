<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Password;
use Phalcon\Validation\Validator\PresenceOf;

class LoginForm extends Form
{

    public function initialize()
    {
        $name = new Text(
            "name",
            [
                "maxlength" => 30,
                "placeholder" => "Введите своё имя",
                "class" => "form-control"
            ]
        );
        $name->setLabel("Имя пользователя");

        $name->setFilters(
            [
                "string",
                "trim",
            ]
        );

        $name->addValidators([
            new PresenceOf([
                'message' => 'Поле Имя не должно быть пустым'
            ])
        ]);

        $this->add($name);


        $password = new Password(
            "password",
            [
                "maxlength" => 30,
                "placeholder" => "Введите пароль",
                "class" => "form-control"
            ]
        );
        $password->setLabel("пароль");

        $this->add($password);


    }

}