<?php

namespace Core;

use App\Config;


class View {

    public static function render($view, $args=[]){

        // convertinf associative array into individual variables
        extract($args, EXTR_SKIP);

        $file = '../App/Views/'. $view .'.php'; // relative to Core directory

        if (is_readable($file)) {

            require $file;

        } else {

            echo "$file not found";

        }

    }

}