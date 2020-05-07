<?php

class Pic {

    private $db;

    public function __construct(){

        $this->db = new DB;

    }

    public function all_pics(){

        $this->db->query('SELECT i.id, i.user_id, i.img_name, i.uploaded_at, u.username, u.profile_img 
                            FROM images i JOIN users u ON i.user_id = u.id
                                ORDER BY i.uploaded_at DESC');
        
        return $this->db->getAll();

    }

    public function user_pics($user_id){

        $this->db->query('SELECT i.id, i.user_id, i.img_name, u.username FROM images i JOIN users u ON i.user_id = u.id WHERE i.user_id = :id');
        $this->db->bind(':id', $user_id);
        $this->db->execute();

        $rows = $this->db->getAll();

        return $rows;

    }

    public function add_pic($user_id, $img_name){

        $this->db->query('INSERT INTO images (user_id, img_name) VALUES (:id, :img_name)');
        $this->db->bind(':id', $user_id);
        $this->db->bind(':img_name', $img_name);
        $this->db->execute();

    }

    public function get_img($img_id){

        $this->db->query('SELECT * FROM images WHERE id = :id');
        $this->db->bind(':id', $img_id);
        $this->db->execute();

        $row = $this->db->getSingle();

        if ($this->db->rowCount() > 0) {
            
            return $row;

        } else {
            
            return false;

        }

    }

    public function delete_pic($img_id){

        $this->db->query('DELETE FROM images WHERE id = :id');
        $this->db->bind(':id', $img_id);
        $this->db->execute();

    }

}