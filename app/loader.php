<?php

// config
require_once 'config/config.php';

// helpers
require_once 'helpers/functions.php';
require_once 'helpers/session.php';
require_once 'helpers/CsrfToken.php';


// libraries autoload
spl_autoload_register(function($class){

    require_once 'libraries/'. $class .'.php'; 

});