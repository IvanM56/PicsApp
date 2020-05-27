<?php

namespace App\Helpers;

use App\Config;


class Redirect {

    public static function to($url){ 

        if($url === 'home'){
    
            header('Location: '. Config::ROOTURL);
    
        } else {
    
            header('Location: '. Config::ROOTURL . $url);
    
        }
      
    }
}