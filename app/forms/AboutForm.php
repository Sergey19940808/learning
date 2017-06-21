<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Validation\Validator\PresenceOf;

class AboutForm extends Form
{
    public function initialize()
    {

        $about = new TextArea(
            "about",
            [
                "placeholder" => "Расскажите о себе",
                "cols" => 10,
                "rows" => 20,
                "class" => "form-control"
            ]
        );

        $about->setLabel("Обо мне:");

        $about->setFilters(
            [
                "string",
                "trim"
            ]
        );

        $about->addValidators([
            new PresenceOf([
                'message' => 'Поле Обо мне не должно быть пустым'
            ])
        ]);

        $this->add($about);
    }

}