<?php

session_start();

function session($user){

    $_SESSION['id'] = $user->id;
    $_SESSION['email'] = $user->email;
    $_SESSION['username'] = $user->username;
    $_SESSION['profile_img'] = $user->profile_img;
    
    redirect('home');

}