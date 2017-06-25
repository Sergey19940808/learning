<?php

use Phalcon\Mvc\Controller;

class TestController extends Controller
{

    public function initialize()
    {
        $this->tag->setTitle("Learning");
    }
    /**public function showAction()
    {
        $json = file_get_contents("http://vokuro/test/users"); // получить данные со второго сервера
        $users = json_decode($json,false);
        $this->view->users = $users; // передать в представление
    }*/

    public function showAction()
    {
        $this->tag->prependTitle("Полученные данные :: ");

        $ch = curl_init('http://vokuro/test/users');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        curl_close($ch);

        $users = json_decode($result);
        $this->view->users = $users;
    }
}