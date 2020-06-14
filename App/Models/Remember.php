<?php

namespace App\Models;

use PDO;
use App\Helpers\RememberMeToken;
use App\Models\User;


class Remember extends \Core\DB {


    public static function findToken($token){
    
        $token_obj = new RememberMeToken($token);
        $token_hash = $token_obj->hashToken();

        $db = static::getDB();

        $stmt = $db->prepare('SELECT * FROM remember WHERE token_hash = :token_hash');
        $stmt->bindValue(':token_hash', $token_hash, PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_OBJ);

        if ($row) {
            return $row;
        } else {
            return false;    
        }

    }

    public static function deleteToken($token_hash){

        $db = static::getDB();

        $stmt = $db->prepare('DELETE FROM remember WHERE token_hash = :token_hash');
        $stmt->bindValue(':token_hash', $token_hash, PDO::PARAM_STR);
        $stmt->execute();

    }

    public static function getUser($id){

        return User::get_user($id);
    }

}