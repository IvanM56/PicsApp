<?php


namespace App\Helpers; 


class RandomString {

    public static function create(){

        $rnd_string = bin2hex(random_bytes(24));

        return $rnd_string;
    }

}


