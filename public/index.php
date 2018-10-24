<?php
use Phalcon\Mvc\View\Engine\Php as PhpEngine;

// Define some absolute path constants to aid in locating resources
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
define('VERSION', \Phalcon\Version::get());

// Register an autoloader
$loader = new \Phalcon\Loader();
$loader->registerDirs(
    [
        APP_PATH . '/controllers/',
        APP_PATH . '/views/'
    ]
)->registerNamespaces(
    [
        'TestApp\Controllers' => APP_PATH . '/controllers/'
    ]
);
$loader->register();

// Create a DI
$di = new \Phalcon\Di\FactoryDefault();
$di->set('view', function(){
    $view = new \Phalcon\Mvc\View();
    $view->setViewsDir(APP_PATH . '/views/');
    $view->registerEngines([
        '.phtml' => PhpEngine::class
    ]);
    return $view;
});

//Route
$di->set('router', function() {
    $router = new \Phalcon\Mvc\Router\Annotations(false);
    $router->removeExtraSlashes(true);
    $router->setDefaultNamespace('TestApp\Controllers');
    $router->addResource('TestApp\Controllers\Index', '/');
    return $router;
});

$application = new \Phalcon\Mvc\Application($di);
try {
    // Handle the request
    $response = $application->handle();
    $response->send();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
    echo '<pre>'.$e->getTraceAsString().'</pre>';
}
