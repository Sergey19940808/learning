<?php

use Phalcon\Mvc\Controller;

class RobotsController extends Controller
{
    /**
     * method init controller
     */
    public function initialize()
    {
        $this->tag->setTitle("Learning");
    }


    /**
     * action add robots in the user
     */
    public function addAction()
    {
        $form = new RobotForm;
        $user = Users::findFirst($this->session->get("auth-id"));

        if ($this->request->isGet()) {
            $this->tag->prependTitle("Добавить робота :: ");
        }

        if ($this->request->isPost()) {
            if (!$form->isValid($this->request->getPost())) {
                foreach ($form->getMessages() as $message) {
                    $this->flashSession->error($message);
                }
                return $this->response->redirect(
                    [
                        "for" => "robot-add",
                        "name" => $user->name
                    ]
                );
            } else {

                $robot = new Robots();
                $robot->name = $this->request->getPost("name");
                $robot->type = $this->request->getPost("type");
                $robot->year = $this->request->getPost("year");
                $robot->users_id = $user->id;


                if ($robot->save()) {
                    $this->flashSession->success("Вы добавили нового робота !");
                    $this->session->set("robot-id", $robot->id);
                    return $this->response->redirect(
                        [

                            "for" => "user-show",
                            "name" => $this->session->get("auth-name")
                        ]
                    );

                } else {

                    $this->flashSession->error($robot->getMessages());
                }

            }
        }

        return $this->view->form = $form;

    }




    /**
     * action show edit robot
     */
    public function editAction()
    {
        $robot = Robots::findFirst($this->session->get("robot-id"));
        if ($this->request->isGet()) {
            $this->tag->prependTitle("Редактировать робота :: ");
            $user = $this->session->get("auth-id");
            if (!$robot) {
                $this->flashSession->error(
                    "Робот не найден"
                );
                return $this->response->redirect("users/usershow/$user->name");
            }

        }

        $this->view->form = new RobotForm(
            $robot,
            [
                "edit" => true,
            ]
        );
    }


    /**
     * action run edit robot
     */
    public function saveAction()
    {
        if ($this->request->isPost()) {
            $robot = Robots::findFirst($this->session->get("robot-id"));
            $user = $this->session->get("auth-name");
            if (!$robot) {
                $this->flashSession->error("Робот не найден");
                return $this->response->redirect("users/usershow/$user");
            }

            $form = new RobotForm();
            $this->view->form = $form;

            $data = $this->request->getPost();

            if (!$form->isValid($data, $robot)) {
                foreach ($form->getMessages() as $message) {
                    $this->flashSession->error($message);
                }

                return $this->response->redirect(
                    [
                        "for" => "robot-edit",
                        "id" => $robot->id

                    ]
                );
            }

            if ($robot->save() == false) {
                foreach ($user->getMessages() as $message) {
                    $this->flashSession->error($message);
                }

                return $this->response->redirect(
                    [
                        "for" => "robot-edit",
                        "id" => $this->session->get("robot-id")

                    ]
                );

            }

            $form->clear();

            $this->flashSession->success("Вы обновили информацию о роботе");

            return $this->response->redirect(
                [
                    "for" => "user-show",
                    "name" => $user

                ]
            );
        }

    }



    /**
     * action delete robot
     */
    public function deleteAction($id)
    {
        $robot = Robots::findFirstById($id);
        $user = $this->session->get("auth-id");

        if ($robot->delete()) {
            $this->flashSession->success("Вы успешно удалили робота");
            return $this->response->redirect("/users/usershow/$user->name");

        } else {
            $this->flashSession->error($robot->getMessages());
            return $this->response->redirect("/users/usershow/$user->name");

        }

    }


}