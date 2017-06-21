<?php

use Phalcon\Mvc\Controller;

class SessionController extends Controller
{
    public function pageAction()
    {
        if ($this->session->get("auth-name") === null) {
            $this->flashSession->error("Вы вошли как гость, вы должны войти или зарегиcтрироваться");
            return $this->response->redirect("/");
        } else {
            return $this->response->redirect(
                [
                    "for" => "user-show",
                    "name" => $this->session->get("auth-name")
                ]
            );
        }
    }
}