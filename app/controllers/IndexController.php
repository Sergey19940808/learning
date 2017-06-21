<?php

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{


    /**
     * method init controller
     */
    public function initialize()
    {
        $this->tag->setTitle("Learning");
    }


    /**
     * action index
     */
    public function indexAction()
    {
        $this->tag->prependTitle("Домашняя :: ");

    }

}

