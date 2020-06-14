<?php

// entry point, tzv. front controller

session_start(); 


/* AUTOLOAD CLASSES */
spl_autoload_register(function($class){
    $root = dirname(__DIR__);   // get the parent directory
    $file = $root. '/' .str_replace('\\', '/', $class). '.php';

    if (is_readable($file)) {
        require $file;
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
