<?php

namespace App\Models;

use PDO;


class User extends \Core\DB {


    public static function getAll(){

        try {

            $db = static::getDB();
            $stmt = $db->query('SELECT * FROM users ORDER BY created_at');
            $results = $stmt->fetchAll(PDO::FETCH_OBJ);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        
    }

 
    public static function find_by_username($username){

        try {
            
            $db = static::getDB();

            $stmt = $db->prepare('SELECT * FROM users WHERE username = :username');
            $stmt->bindValue(':username', $username);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_OBJ);

            if ($row) {
                return true;
            } else {
                return false;
            }

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        
    }

    public static function find_by_email($email){

        try {
            
            $db = static::getDB();

            $stmt = $db->prepare('SELECT * FROM users WHERE email = :email');
            $stmt->bindValue(':email', $email);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_OBJ);

            if ($row) {
                return true;
            } else {
                return false;    
            }

        } catch (PDOException $e) {
            echo $e->getMessage();
        }   

    }

    public static function register($data){

        try {
            
            $db = static::getDB(); 

            $stmt = $db->prepare('INSERT INTO users (username, email, password, profile_img) VALUES (:username, :email, :password, :profile_img)');
            $stmt->bindValue(':username', $data['username']);
            $stmt->bindValue(':email', $data['email']);
            $stmt->bindValue(':password', $data['password']);
            $stmt->bindValue(':profile_img', $data['profile_img']);
            $stmt->execute();

        } catch (PDOExceptio $e) {
            echo $e->getMessage();
        }
        
    }

    public static function login($data){

        try {
            
            $db = static::getDB();

            $stmt = $db->prepare('SELECT * FROM users WHERE email = :email');
            $stmt->bindValue(':email', $data['email']);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_OBJ);

            $hashpass = $row->password;

            if (password_verify($data['password'], $hashpass)){
                return $row;
            } else {
                return false;
            }

        } catch (PDOException $e) {
            echo $e->getMessage();
        }       
        
    }


    public function get_user($id){

        try {
            
            $db = static::getDB();

            $stmt = $db->prepare('SELECT * FROM users WHERE id = :id');
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_OBJ);

            if ($stmt->rowCount() > 0) {
                return $row;
            } else {
                return false;
            }

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        
    }

    public function get_user_and_pics($id){

        try {
            
            $db = static::getDB();

            $stmt = $db->prepare('SELECT u.id, u.username, u.email, u.profile_img, i.user_id, i.img_name 
                                FROM users u JOIN images i ON u.id = i.user_id WHERE u.id = :id');
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            $rows = $stmt->fetchAll(PDO::FETCH_OBJ);

            if ($stmt->rowCount() > 0) {      
                return $rows;
            } else {   
                return false;
            }

        } catch (PDOException $e) {
            echo $e->getMessage();
        }      

    }

    /*public function get_user_and_pic_count($id){

        $db = static::getDB();

        $stmt = $db->prepare('SELECT u.id, u.username, u.email, u.profile_img, COUNT(i.user_id) as pic_count 
                            FROM users u 
                                JOIN images i ON i.user_id = u.id 
                                    WHERE i.user_id = :id 
                                        GROUP BY u.username'); 
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_OBJ);

        if ($stmt->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }

    }*/


    public function update($data){

        try {
            
            $db = static::getDB();

            $stmt = $db->prepare('UPDATE users SET username = :username, email = :email, profile_img = :profile_img WHERE id = :id');
            $stmt->bindValue(':username', $data['username']);
            $stmt->bindValue(':email', $data['email']);
            $stmt->bindValue(':profile_img', $data['profile_img']);
            $stmt->bindValue(':id', $data['id']);
            $stmt->execute();

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        
    }

    public function insert_token($email, $token){

        try {
            
            $db = static::getDB();

            $stmt = $db->prepare('UPDATE users SET token = :token, token_expires = DATE_ADD(NOW(), INTERVAL 5 MINUTE) WHERE email = :email');
            $stmt->bindValue(':token', $token);
            //$this->db->bind(':token_expires', DATE_ADD(NOW(), INTERVAL 5 MINUTE));
            $stmt->bindValue(':email', $email);
            $stmt->execute();

        } catch (PDOException $e) {
            echo $e->getMessage();
        }        

    }

    public function delete_token($email, $token){

        try {
            
            $db = static::getDB();

            $stmt = $db->prepare("UPDATE users SET token = '' WHERE email = :email");
            $stmt->bindValue(':email', $email);
            $stmt->execute();

        } catch (PDOException $e) {
            echo $e->getMessage();
        }       
        
    }

    public function find_by_email_and_token($email, $token){

        try {
            
            $db = static::getDB();

            $stmt = $db->prepare("SELECT * FROM users WHERE email = :email AND token = :token AND token != '' AND token_expires > NOW()");
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':token', $token);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_OBJ);

            if ($stmt->rowCount() > 0) {    
                return true;         
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        
    }

    public function update_password($data){ 

        try {
            
            $db = static::getDB();

            $stmt = $db->prepare("UPDATE users SET password = :password, token = '' WHERE email = :email");
            $stmt->bindValue(':password', $data['password']);
            $stmt->bindValue(':email', $data['email']);
            $stmt->execute();

        } catch (PDOException $e) {
            echo $e->getMessage();
        }       

    }

    public function delete_profile($id){

        try {
            
            $db = static::getDB();

            $stmt = $db->prepare('DELETE FROM users WHERE id = :id');
            $stmt->bindValue(':id', $id);
            $stmt->execute();

        } catch (\Throwable $th) {
            echo $e->getMessage();
        }    

    }

}