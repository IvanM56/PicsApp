<?php



class CsrfToken {


    public static function create(){

        //$token = bin2hex(random_bytes(24));

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