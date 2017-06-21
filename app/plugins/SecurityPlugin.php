<?php

use Phalcon\Acl;
use Phalcon\Acl\Role;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Resource;
use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;

class SecurityPlugin extends Plugin
{



    public function getAcl()
    {
        $acl = new AclList();

        $acl->setDefaultAction(
            Acl::DENY
        );


        $roles = [
            "users"  => new Role("Users"),
            "guests" => new Role("Guests"),
        ];

        foreach ($roles as $role) {
            $acl->addRole($role);
        }



        $privateResources = [
            "users" => ["logout", "usershow", "userabout", "useraddabout", "userdelete"],
            "robots" => ["add", "delete"]
        ];

        foreach ($privateResources as $resourceName => $actions) {
            $acl->addResource(
                new Resource($resourceName),
                $actions
            );
        }



        $publicResources = [
            "index" => ["index"],
            "errors" => ["show404", "show500"],
            "users" => ["register", "loginshow", "login"]
        ];

        foreach ($publicResources as $resourceName => $actions) {
            $acl->addResource(
                new Resource($resourceName),
                $actions
            );
        }


        foreach ($roles as $role) {
            foreach ($publicResources as $resource => $actions) {
                $acl->allow(
                    $role->getName(),
                    $resource,
                    "*"
                );
            }
        }


        foreach ($privateResources as $resource => $actions) {
            foreach ($actions as $action) {
                $acl->allow(
                    "Users",
                    $resource,
                    $action
                );
            }
        }

    }


    /**
     * @param Event $event
     * @param Dispatcher $dispatcher
     * @return bool
     */
    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
    {
        // Проверяем, установлена ли в сессии переменная "auth" для определения активной роли.
        $auth = $this->session->get("auth-name");

        if (!$auth) {
            $role = "Guests";
        } else {
            $role = "Users";
        }

        // Получаем активный контроллер/действие от диспетчера
        $controller = $dispatcher->getControllerName();
        $action     = $dispatcher->getActionName();

        // Получаем список ACL
        $acl = $this->getAcl();

        // Проверяем, имеет ли данная роль доступ к контроллеру (ресурсу)
        $allowed = $acl->isAllowed($role, $controller, $action);

        if (!$allowed) {
            // Если доступа нет, перенаправляем его на контроллер "index".
            $this->flashSession->error(
                "У вас нет доступа к данному модулю"
            );

            $dispatcher->forward(
                [
                    "controller" => "index",
                    "action"     => "index",
                ]
            );

            // Возвращая "false" мы приказываем диспетчеру прервать текущую операцию
            return false;
        }
    }

}