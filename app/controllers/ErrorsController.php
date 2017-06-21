<?php

use Phalcon\Mvc\Controller;


class ErrorsController extends Controller
{


    /**
     * method init controller
     */
    public function initialize()
    {
        $this->tag->setTitle("Learning");
    }



    /**
     * show view error 404
     */
    public function show404Action()
    {
        $this->tag->prependTitle("Страница не найдена :: ");

    }



    /**
     * show view error 500
     */
    public function show500Action()
    {
        $this->tag->prependTitle("Ошибка сервера :: ");

    }

}