<?php


function home(){
    
    return 'http://localhost:8080/picsapp_mvc/';

}

function register(){
    
    return 'http://localhost:8080/picsapp_mvc/users/register';

}

function login(){
    
    return 'http://localhost:8080/picsapp_mvc/users/login';

}

function logout(){
    
    return 'http://localhost:8080/picsapp_mvc/users/logout';

}

function redirect($url){

    if($url == 'home'){

        header("Location: http://localhost:8080/picsapp_mvc");

    } else {

        header("Location: http://localhost:8080/picsapp_mvc/$url");

    }
    
    
}


function logged_in(){

    if (isset($_SESSION['id'])) {
        
        return true;

    } else {

        return false;
        
    }
}


function random_string(){

    $rnd_string = bin2hex(random_bytes(24));

    /*$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $rnd_string = str_shuffle($chars);
    $rnd_string = substr($rnd_string, 0, $length);*/

    return $rnd_string;

}


function dd(){

    // dump and die funkcija
}


