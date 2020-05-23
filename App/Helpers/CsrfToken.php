<?php

namespace App\Helpers;

class CsrfToken {


    public static function create(){

        $token = random_string();

        $_SESSION['csrf_token'] = $token;

        return $token;

    }

    public static function check($token){

        if (isset($_SESSION['csrf_token']) && $_SESSION['csrf_token'] === $token) {
            
            return true;

        } else {

            return false;

        }

    }
}