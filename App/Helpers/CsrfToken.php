<?php

namespace App\Helpers;

use App\Helpers\Session;
use App\Helpers\RandomString;

class CsrfToken {


    public static function create(){

        // $token = random_string();

        $token = RandomString::create();

        $_SESSION['csrf_token'] = $token;

        return $token;

    }

    public static function check($token){

        if (Session::exists('csrf_token') && Session::get('csrf_token') === $token) {
            
            return true;

        } else {

            return false;

        }

    }
}