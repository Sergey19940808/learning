<?php

use Phalcon\Mvc\Controller;

class UsersController extends Controller
{


    /**
     * method init controller
     */
    public function initialize()
    {
        $this->tag->setTitle("Learning");
    }



    /**
     * register user action
     */
    public function registerAction()
    {
        $user = new Users();
        $form = new RegisterForm($user);

        if ($this->request->isGet()) {
            $this->tag->prependTitle("Регистрация :: ");
        }


        if ($this->request->isPost()) {
            if (!$form->isValid($this->request->getPost())) {
                foreach ($form->getMessages() as $message) {
                    $this->flashSession->error($message);
                }

                return $this->response->redirect("users/loginshow");

            } else {

                $name = $this->request->getPost("name");
                $email = $this->request->getPost("email");
                $password = $this->request->getPost("password");


                $user->name = $name;
                $user->email = $email;
                $user->password = $this->security->hash($password);


                if (!$user->save()) {
                    $this->flashSession->error($user->getMessages());
                    $this->dispatcher->forward([
                        "action" => "register"
                    ]);

                } else {
                    $this->session->set("auth-id", $user->id);
                    $this->session->set("auth-name", $user->name);
                    $this->flashSession->success("Пользователь зарегиcтрирован");
                    return $this->response->redirect(
                        [
                            "for" => "user-show",
                            "name" => $user->name
                        ]);

                }
            }

        }

        return $this->view->form = $form;


    }


    /**
     * show form login
     */
    public function loginShowAction() {

        $this->tag->prependTitle("Войти :: ");
        $form = new LoginForm();
        $this->view->form = $form;

    }

    
    /**
     * login user action
     */
    public function loginAction()
    {

        $form = new LoginForm();

        if ($this->request->isPost()) {
            if (!$form->isValid($this->request->getPost())) {
                foreach ($form->getMessages() as $message) {
                    $this->flashSession->error($message);
                }
                return $this->response->redirect("users/loginshow");

            } else {
                $name = $this->request->getPost("name");
                $password = $this->request->getPost("password");

                $user = Users::findFirstByName($name);


                if (!$user) {
                    $this->flashSession->error("Пользователь не найден");
                    return $this->response->redirect("/");
                } else {

                    if ($this->security->checkHash($password, $user->password)) {

                        $this->session->set("auth-id", $user->id);
                        $this->session->set("auth-name", $user->name);
                        $this->flashSession->success("Вы успешно вошли");
                        /** @var $user - параметр name */
                        return $this->response->redirect("/users/usershow/$name");
                    }
                }
            }
        }

    }


    /**
     * logout user action
     */
    public function logoutAction()
    {
        $user = Users::findFirst($this->session->get("auth"));

        if ($user !== null) {
            $this->session->remove("auth-id");
            $this->session->remove("auth-name");
            $this->flashSession->success("Вы успешно вышли");
            return $this->response->redirect("/");

        } else {
            $this->flashSession->error("Нет данных в сессии");
            return $this->response->redirect("/users/usershow/$user->name");
        }


    }


    /**
     * show form user profile action
     */
    public function userShowAction()
    {
        $this->tag->prependTitle("Страница пользователя :: ");
        $user = Users::findFirst($this->session->get("auth-id"));



        $this->view->name = $user->name;
        $this->view->about = $user->about;
        $this->view->email = $user->email;
        $this->view->robots = $user->robots;

    }



    /**
     * show user about action
     */
    public function userAboutAction()
    {

        $this->tag->prependTitle("Добавить информацию обо мне :: ");
        $form = new AboutForm();
        $this->view->form = $form;
    }




    /**
     * add about user action
     */
    public function userAddAction()
    {
        $form = new AboutForm();
        $user = Users::findFirst($this->session->get("auth-id"));

        if ($this->request->isPost()) {
            if (!$form->isValid($this->request->getPost())) {
                foreach ($form->getMessages() as $message) {
                    $this->flashSession->error($message);
                }
                return $this->response->redirect(
                    [
                        "for" => "user-show",
                        "name" => $user->name
                    ]
                );
            } else {

                $user->about = $this->request->getPost("about");

                if ($user->save()) {
                    $this->flashSession->success("Вы добавили информацию о себе");
                    return $this->response->redirect([
                        "for" => "user-show",
                        "name" => $user->name
                    ]);

                } else {
                    echo "Произошли следующие проблемы: <br>";

                    $messages = $user->getMessages();

                    foreach ($messages as $message) {
                        echo $message->getMessage(), "<br/>";
                    }
                }

            }
        }

    }


    /**
     * show form edit user about
     */
    public function userEditAction()
    {
        $this->tag->prependTitle("Редактировать информацию обо мне :: ");
        if ($this->request->isGet()) {
            $user = Users::findFirst($this->session->get("auth-id"));
            if (!$user) {
                $this->flashSession->error(
                    "Пользователь не найден"
                );
                return $this->response->redirect("/");
            }
            $this->view->form = new AboutForm(
                $user,
                [
                    "edit" => true,
                ]
            );
        }

    }



    /**
     * action execute edit info about
     */
    public function userSaveAction()
    {
        if ($this->request->isPost()) {
            $user = Users::findFirst($this->session->get("auth-id"));
            if (!$user) {
                $this->flashSession->error("Пользователь не найден");
                return $this->response->redirect("/");
            }

            $form = new AboutForm();
            $this->view->form = $form;

            $data = $this->request->getPost();

            if (!$form->isValid($data, $user)) {
                foreach ($form->getMessages() as $message) {
                    $this->flashSession->error($message);
                }

                return $this->response->redirect(
                    [
                        "for" => "user-edit",
                        "name" => $user->name

                    ]
                );
            }

            if ($user->save() == false) {
                foreach ($user->getMessages() as $message) {
                    $this->flashSession->error($message);
                }

                return $this->response->redirect(
                    [
                        "for" => "user-edit",
                        "name" => $user->name

                    ]
                );

            }

            $form->clear();

            $this->flashSession->success("Вы обновили информацию о себе");

            return $this->response->redirect(
                [
                    "for" => "user-show",
                    "name" => $user->name

                ]
            );
        }

    }


    /**
     * delete user action
     */
    public function userDeleteAction()
    {

        $user = Users::findFirst($this->session->get("auth-id"));

        if (!$user) {
            $this->flashSession->error("Пользователь не найден");
            return $this->response->redirect([
                "for" => "user-show",
                "name" => $user->name
                ]);

        }

        if (!$user->delete()) {
            foreach ($user->getMessages() as $message){
                $this->flashSession->error($message);
            }
            return $this->response->redirect([
                "for" => "user-show",
                "name" => $user->name
            ]);

        }

        $this->session->destroy("auth-id");
        $this->session->destroy("auth-name");
        $this->flashSession->success("Вы успешно удалили себя");
        return $this->response->redirect("/");

    }

}
