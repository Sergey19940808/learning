
<?php

use Phalcon\Mvc\Router;

$router = new Router();

$router->add(
    "/users/usershow/{name}",
    [
        "controller" => "users",
        "action" => "usershow",
    ])->setName("user-show");


$router->add(
    "/users/userabout/{name}",
    [
        "controller" => "users",
        "action" => "userabout",
    ])->setName("user-about");



$router->add(
    "/users/useredit/{name}",
    [
        "controller" => "users",
        "action" => "useredit",
    ])->setName("user-edit");




$router->add(
    "/robots/add/{name}",
    [
        "controller" => "robots",
        "action" => "add",
    ])->setName("robot-add");


$router->add(
    "/robots/edit/{id}",
    [
        "controller" => "robots",
        "action" => "edit",
    ])->setName("robot-edit");


$router->add(
    "/test/accept",
    [
        "controller" => "test",
        "action" => "accept",
    ])->setName("accept");


return $router;