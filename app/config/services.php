<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Php as PhpEngine;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Flash\Direct as Flash;
use Phalcon\Flash\Session as FlashSession;
use Phalcon\Logger\Adapter\File as FileLogger;
use Phalcon\Logger;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\Dispatcher;



define("APP_PATH", dirname(__DIR__));

/**
 * Shared configuration service
 */
$di->setShared("config", function () {
    return include APP_PATH . "/config/config.php";
});



/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared("url", function () {
    $config = $this->getConfig();

    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
});




/**
 * Setting up the view component
 */
$di->setShared("view", function () {
    $config = $this->getConfig();

    $view = new View();
    $view->setDI($this);
    $view->setViewsDir($config->application->viewsDir);

    $view->registerEngines([
        ".volt" => function ($view) {
            $config = $this->getConfig();

            $volt = new VoltEngine($view, $this);

            $volt->setOptions([
                "compiledPath" => $config->application->cacheDir,
                "compiledSeparator" => "_"
            ]);

            return $volt;
        },
        ".phtml" => PhpEngine::class

    ]);

    return $view;
});




/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared(
/**
 * @return mixed
 */
    "db",
        function () {
    $config = $this->getConfig();
    $eventsManager = new EventsManager();
    $logger = new FileLogger(APP_PATH. "/logs/debug.log");


    // Слушаем все события базы данных
    $eventsManager->attach(
        "db:beforeQuery",
        function ($event, $connection) use ($logger) {
            $logger->log(
                $connection->getSQLStatement(),
                Logger::INFO
            );
        }
    );



    $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
    $params = [
        "host"     => $config->database->host,
        "username" => $config->database->username,
        "password" => $config->database->password,
        "dbname"   => $config->database->dbname,
        "charset"  => $config->database->charset
    ];

    if ($config->database->adapter == "Mysql") {
        unset($params["charset"]);
    }

    $connection = new $class($params);

    $connection->setEventsManager($eventsManager);
    return $connection;
});



/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->setShared("modelsMetadata", function () {
    return new MetaDataAdapter();
});



/**
 * Register the session flash service with the Twitter Bootstrap classes
 */
$di->setShared("flash", function () {
    $flash = new Flash(
        [
        "error"   => "alert alert-danger",
        "success" => "alert alert-success",
        "notice"  => "alert alert-info",
        "warning" => "alert alert-warning"
        ]
    );
    return $flash;
});



$di->setShared("flashSession", function () {
        $flashSession = new FlashSession(
            [
                "error"   => "alert alert-danger",
                "success" => "alert alert-success",
                "notice"  => "alert alert-info",
                "warning" => "alert alert-warning"
            ]
        );
        return $flashSession;
});


/**
 * Start the session the first time some component request the session service
 */
$di->setShared("session", function () {
    $session = new SessionAdapter();
    $session->start();

    return $session;
});



/**
 * set service connect route
 */
$di->setShared("router", function () {

    return require APP_PATH . "/config/router.php";
});


$di->setShared(
    "dispatcher", function () {

    // Создаем менеджер событий
    $eventsManager = new EventsManager();

    // Плагин безопасности слушает события, инициированные диспетчером
    $eventsManager->attach(
        "dispatcher:beforeExecuteRoute",
        new SecurityPlugin()
    );

    // Отлавливаем исключения и not-found исключения, используя NotFoundPlugin
    $eventsManager->attach(
        "dispatcher:beforeException",
        new NotFoundPlugin()
    );


    $dispatcher = new Dispatcher();

    // Связываем менеджер событий с диспетчером
    $dispatcher->setEventsManager($eventsManager);

    return $dispatcher;
});