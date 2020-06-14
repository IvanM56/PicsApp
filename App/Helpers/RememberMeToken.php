<?php

namespace App\Helpers;

use App\Helpers\RandomString;
use App\Config;

class RememberMeToken {


    protected $token;


    public function __construct($existing_token = null){

        if ($existing_token) {
            // assing it to property
            $this->token = $existing_token;

        } else {
            // create new 
            $this->token = RandomString::create();

        }
        
    }

    public function getToken(){

        return $this->token;
    }

    public function hashToken(){

        return hash_hmac('sha256', $this->token, Config::SECRET_KEY);

    }
}