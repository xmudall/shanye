<?php

use Phalcon\Logger,
    Phalcon\Db\Adapter\Pdo\Mysql as Connection, 
    Phalcon\Events\Manager as EventsManager,
    Phalcon\Logger\Adapter\File;

try {

    // include_once('../lib/httpful.phar');

    //Register an autoloader
    $loader = new \Phalcon\Loader();
    $loader->registerDirs(array(
	//'Common' => '../app/common',
        '../app/common/',
        '../app/controllers/',
        '../app/models/',
        '../app/plugins/',
    ))->register();

    //Create a DI
    $di = new Phalcon\DI\FactoryDefault();

    // setup database
    $di->set('db', function() use ($di) {

        $eventsManager = $di->getShared('eventsManager'); 
        // $eventsManager = new EventsManager();

        $logger = new File("../log/sql.log");

        $eventsManager->attach('db', function($event, $connection) use ($logger) {
            if ($event->getType() == 'beforeQuery') {
                $logger->log($connection->getSQLStatement(), Logger::INFO);
            }
        });

        $connection = new \Phalcon\Db\Adapter\Pdo\Mysql(array(
            "host" => "localhost",
            "username" => "udall",
            "password" => "123456",
            "dbname" => "shanye",
            "charset" => "utf8",
        ));

        $connection->setEventsManager($eventsManager);

        return $connection;
    });

    //Setup the view component
    $di->set('view', function(){
        $view = new \Phalcon\Mvc\View();
        $view->setViewsDir('../app/views/');
        $view->registerEngines(array(
            ".phtml" => function($view, $di) {
                $volt = new \Phalcon\Mvc\View\Engine\Volt($view, $di);
                $compiler = $volt->getCompiler();
                $compiler->addFilter('collapse', function($resolvedArgs, $exprArgs) use ($compiler) {
                    $str = $compiler->expression($exprArgs[0]['expr']);
                    if (isset($exprArgs[1])) {
                        $len = $compiler->expression($exprArgs[1]['expr']);
                    } else {
                        $len = '10';
                    }
                    error_log($str . ':' . $len);
                    if ($len < 3) {
                        return $str;
                    } else {
                        // generates a collapse expression
                        $expr = 'strlen(' . $str . ') <= ' . $len . ' ? ' . $str . ' : substr(' . $str . ', 0, ' . ($len-2) . ') . ".."';
                        error_log($expr);
                        return $expr;
                    }
                });
                return $volt;
            },
        ));
        return $view;
    });

    //Setup a base URI so that all generated URIs include the "tutorial" folder
    $di->set('url', function(){
        $url = new \Phalcon\Mvc\Url();
        $url->setBaseUri('/cms/');
        return $url;
    });

    //Read the configuration
    $config = new Phalcon\Config\Adapter\Ini('../app/config/config.ini');
    $di->set('config', $config);

    // setup dispatcher
    // $di->set('dispatcher', function() use ($di) { 
    //     
    //     //Obtain the standard eventsManager from the DI 
    //     $eventsManager = $di->getShared('eventsManager'); 
    //
    //     //Instantiate the Security plugin 
    //     $security = new Security($di); 
    //
    //     //Listen for events produced in the dispatcher using the Security plugin 
    //     $eventsManager->attach('dispatch', $security); $dispatcher = new Phalcon\Mvc\Dispatcher(); 
    //
    //     //Bind the EventsManager to the Dispatcher 
    //     $dispatcher->setEventsManager($eventsManager);
    //
    //     return $dispatcher;
    // });

    // setup session
    $di->setShared('session', function() {
        $session = new Phalcon\Session\Adapter\Files();
        $session->start();
        return $session;
    });

    //Handle the request
    $application = new \Phalcon\Mvc\Application($di);

    echo $application->handle()->getContent();

} catch(\Phalcon\Exception $e) {
     echo "PhalconException: ", $e->getMessage();
}
