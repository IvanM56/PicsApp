<?php

namespace App\Helpers;

use App\Config;


class Redirect {

    public static function to($url){ 

        if($url === 'home'){
    
            header('Location: '. Config::ROOTURL, true, 303);
            exit;
    
        } else {
    
            header('Location: '. Config::ROOTURL . $url, true, 303);
            exit;
    
        }
      
    }
}