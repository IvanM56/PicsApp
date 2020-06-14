<?php

namespace App;

use App\Helpers\Session;
use App\Helpers\RememberMeToken;
use App\Helpers\Redirect;
use App\Models\User;
use App\Models\Remember;



class Auth {


    public static function login($user, $remember = null){

        // session_regenerate_id(true);

        Session::set('id', $user->id);
        Session::set('email', $user->email);
        Session::set('username', $user->username);
        Session::set('profile_img', $user->profile_img);

        if(isset($remember)){

            $token_obj = new RememberMeToken();
            $token = $token_obj->getToken();
            $token_hash = $token_obj->hashToken();
            $expires_at = time() + 60 * 60 * 24 * 30;

            User::rememberLogin($token_hash, $user->id, $expires_at);

            setcookie('remember_me', $token, $expires_at, '/');

        }

    }
      
    protected static function rememberCookieLogin(){

        $cookie = $_COOKIE['remember_me'] ?? false;

        if ($cookie) {
            
            $rememberedLogin = Remember::findToken($cookie);

            if ($rememberedLogin) {
                // log the user in
                $user = Remember::getUser($rememberedLogin->user_id);

                self::login($user);

                return $user;
            }

        }

    }

    public static function forgetCookieLogin(){

        $cookie = $_COOKIE['remember_me'];

        if ($cookie) {
            
            $rememberedLogin = Remember::findToken($cookie);

            if ($rememberedLogin) {
                
				Remember::deleteToken($rememberedLogin->token_hash);
                
            }

            // deletion parameters must match the creation parameters
            setcookie('remember_me', $cookie, time() - 3600, '/');

        }
    }

    public static function getUser(){

        if (Session::exists('id')) {
            
            return User::get_user(Session::get('id'));

        } else {

			return self::rememberCookieLogin();
			   
        }

    }
    
    public static function loggedIn(){

        if (Session::exists('id')) {
            
            return true;

        } else {

            return false;

        }

    }


}