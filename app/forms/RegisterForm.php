<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Password;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Uniqueness;

class RegisterForm extends Form
{
    public function initialize($model)
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


        $name->addValidators([
            new Uniqueness(
                [
                    "model" => $model,
                    "message" => "Имя пользователя должно быть уникальным"


                ]
            )
        ]);


        $this->add($name);


        $email = new Text(
                "email",
                [
                    "maxlength" => 30,
                    "placeholder" => "Введите своё имя",
                    "class" => "form-control"
                ]
            );

        $email->setLabel("Адрес пользователя");

        $email->setFilters("email");

        $email->addValidators([
            new PresenceOf([
                "message" => 'Поле Email не должно быть пустым'
            ])
        ]);

        $email->addValidators([
            new Uniqueness(
                [
                    "model" => $model,
                    "message" => "Адрес электронной почты должен быть уникальным"


                ]
            )
        ]);


        $this->add($email);

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