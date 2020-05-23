<?php

namespace App\Models;

use PDO;

class Pic extends \Core\DB {

    public static function getAll(){ 

        try {

            $db = static::getDB();
            $stmt = $db->query('SELECT i.id, i.user_id, i.img_name, i.uploaded_at, u.username, u.profile_img 
                                    FROM images i JOIN users u ON i.user_id = u.id 
                                        ORDER BY created_at');

            $results = $stmt->fetchAll(PDO::FETCH_OBJ);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function all_pics(){

        $db = static::getDB();

        $stmt = $db->query('SELECT i.id, i.user_id, i.img_name, i.uploaded_at, u.username, u.profile_img 
                            FROM images i JOIN users u ON i.user_id = u.id
                                ORDER BY i.uploaded_at DESC');
        
        return $stmt->fetchAll(PDO::FETCH_OBJ);

    }

    public function user_pics($user_id){

        $db = static::getDB();
        
        $stmt = $db->prepare('SELECT i.id, i.user_id, i.img_name, i.uploaded_at, u.username FROM images i JOIN users u ON i.user_id = u.id WHERE i.user_id = :id');
        $stmt->bindValue(':id', $user_id);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $rows;

    }

    public function add_pic($user_id, $img_name){

        $db = static::getDB();

        $stmt = $db->prepare('INSERT INTO images (user_id, img_name) VALUES (:id, :img_name)');
        $stmt->bindValue(':id', $user_id);
        $stmt->bindValue(':img_name', $img_name);
        $stmt->execute();

        $stmt = $db->prepare('UPDATE users SET pic_count = pic_count+1 WHERE id = :id');
        $stmt->bindValue(':id', $user_id);
        $stmt->execute();

    }

    public function get_pic($pic_id){

        $db = static::getDB();

        $stmt = $db->prepare('SELECT * FROM images WHERE id = :id'); 
        $stmt->bindValue(':id', $pic_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_OBJ);

        if ($stmt->rowCount() > 0) {    
            return $row;
        } else {          
            return false;
        }

    }

    public function delete_pic($pic_id, $user_id){

        $db = static::getDB();

        $stmt = $db->prepare('DELETE FROM images WHERE id = :id');
        $stmt->bindValue(':id', $pic_id);
        $stmt->execute();

        $stmt = $db->prepare('UPDATE users SET pic_count = pic_count-1 WHERE id = :id ');
        $stmt->bindValue(':id', $user_id);
        $stmt->execute();

    }

}