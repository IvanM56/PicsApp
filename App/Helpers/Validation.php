<?php

namespace App\Helpers;

use App\Models\User;

class Validation {

    private static $errors = array();
    private static $passed = false;

    public static function check($inputs = array()){

        foreach ($inputs as $input => $rules) {

            foreach ($rules as $rule => $rule_value) {
                
                $user_input = $_POST[$input];

                if ($rule === 'required' && empty($user_input)) {
                    
                    self::addError($input, 'This field is required!');
   
                } else if (!empty($user_input)){

                    switch ($rule) {
                        case 'min':
                            if (strlen($user_input) < $rule_value) {
                                self::addError($input, ucfirst($input). ' must be at least ' .$rule_value. ' charachers long');
                            }
                            break;
                        case 'max':
                            if (strlen($user_input) > $rule_value) {
                                self::addError($input, ucfirst($input). ' can\'t be longer than ' .$rule_value. ' charachers');
                            }
                            break;
                        case 'unique':
                            if ($input === 'username') {
                                $username = User::find_by_username($user_input);
                                if ($username) {
                                    self::addError($input, 'This username is already taken');
                                } 
                            } else if ($input === 'email'){
                                $email = User::find_by_email($user_input);
                                if ($email) {
                                    self::addError($input, 'This email is already in use');
                                }
                            }
                            break;
                        case 'current':
                            if ($input === 'username') {
                                $username = User::find_by_username($user_input);
                                if ($username == $user_input) {
                                    // Pass
                                } else {
                                    self::addError($input, 'This username is already taken');
                                }
                            } else if ($input === 'email'){
                                $email = User::find_by_email($user_input);
                                if ($email == $user_input) {
                                    // Pass
                                } else {
                                    self::addError($input, 'This email is already in use');
                                }
                            }
                            break;
                        case 'exists':
                            if ($input === 'email') {
                                $email = User::find_by_email($user_input);
                                if (!$email) {
                                    self::addError($input, 'Invalid email address!');
                                } 
                            }
                            break;
                        case 'matches':
                            if ($user_input != $_POST[$rule_value]) {
                                self::addError($input, 'Passwords don\'t match!');
                            }
                            break;
                        
                    }
                }
            }
        }

        if (empty(self::$errors)) {
            
            self::$passed = true;

        }

    }

    public function addError($input, $error){
         
        self::$errors[$input] = $error;

    }

    public static function hasError($input){
        if (isset(self::$errors[$input])) {
            return self::$errors[$input];
        }
        return false;
    }

    public static function passed(){

        return self::$passed;

    }

    public function getErrors(){

        return self::$errors;

    }

}