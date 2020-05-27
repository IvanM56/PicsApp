<?php

namespace App\Helpers;


class Session {


    public static function set($key, $value){

        return $_SESSION[$key] = $value;
    
    }

    public static function get($key){

        return $_SESSION[$key];

    }

    public static function exists($key){

        if (isset($_SESSION[$key])) {
            
            return true;

        } else {

            return false;

        }

    }

    public static function delete($key){

        if (self::exists($key)) {
            
            unset($_SESSION[$key]);

        }
    }

}


