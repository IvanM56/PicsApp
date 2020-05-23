<?php

// entry point, tzv. front controller

// ovo zawrapati u klasu
require_once '../App/Helpers/functions.php';
require_once '../App/Helpers/session.php';
require_once '../App/Helpers/CsrfToken.php';  



/* AUTOLOAD CLASSES */
spl_autoload_register(function($class){
    $root = dirname(__DIR__);   // get the parent directory
    $file = $root. '/' .str_replace('\\', '/', $class). '.php';

    if (is_readable($file)) {
        require $root. '/' .str_replace('\\', '/', $class). '.php';
    }
});


/* ROUTING */
require '../Core/Router.php';

$router = new Core\Router;

$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('{controller}/{action}');
$router->add('{controller}/{action}/{id:\d+}');
// $router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);

$router->dispatch($_SERVER['QUERY_STRING']);
