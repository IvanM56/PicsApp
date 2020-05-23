<?php

use App\Config;


function redirect($url){

    if($url === 'home'){

        header('Location: '. Config::ROOTURL);

    } else {

        header('Location: '. Config::ROOTURL . $url);
        // header("Location: ROOTURL $url");

    }
    
    
}

// ovo prebaciti u Users controller?
function logged_in(){

    if (isset($_SESSION['id'])) {
        
        return true;

    } else {

        return false;
        
    }
}


function random_string(){

    $rnd_string = bin2hex(random_bytes(24));
    
    return $rnd_string;

}


function dd(){

    // dump and die funkcija
}


