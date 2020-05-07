<?php

class User {

    private $db;

    public function __construct(){

        $this->db = new DB;

    }



    public function find_by_username($username){

        $this->db->query('SELECT * FROM users WHERE username = :username');
        $this->db->bind(':username', $username);

        $row = $this->db->getSingle();

        if ($this->db->rowCount() > 0) {
            
            return true;

        } else {

            return false;

        }
    }
    public function find_by_email($email){

        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->getSingle();

        if ($this->db->rowCount() > 0) {
            
            return true;
            
        } else {

            return false;

        }

    }

    public function register($data){

        $this->db->query('INSERT INTO users (username, email, password, profile_img) VALUES (:username, :email, :password, :profile_img)');
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':profile_img', $data['profile_img']);
        $this->db->execute();

    }

    public function login($data){

        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $data['email']);

        $row = $this->db->getSingle();

        $hashpass = $row->password;

        if (password_verify($data['password'], $hashpass)){

            return $row;

        } else {

            return false;

        }
        
    }

    public function get_user($id){

        $this->db->query('SELECT * FROM users WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->execute();

        $row = $this->db->getSingle();

        if ($this->db->rowCount() > 0) {
            
            return $row;

        } else {

            return false;

        }
    }

    public function get_user_and_pics($id){

        $this->db->query('SELECT u.id, u.username, u.email, u.profile_img, i.user_id, i.img_name 
                            FROM users u JOIN images i ON u.id = i.user_id WHERE u.id = :id');
        $this->db->bind(':id', $id);
        $this->db->execute();

        $rows = $this->db->getAll();

        if ($this->db->rowCount() > 0) {
            
            return $rows;

        } else {
        
            return false;

        }

    }

    public function get_user_and_pic_count($id){

        $this->db->query('SELECT u.id, u.username, u.email, u.profile_img, COUNT(i.user_id) as pic_count 
                            FROM users u 
                                JOIN images i ON i.user_id = u.id 
                                    WHERE i.user_id = :id 
                                        GROUP BY u.username');  // probati bez group by; ionako se dohvaća samo jedan rezultat preko $id-a
        $this->db->bind(':id', $id);
        $this->db->execute();
        
        return $this->db->getSingle();

    }

    public function update($data){

        $this->db->query('UPDATE users SET username = :username, email = :email, profile_img = :profile_img WHERE id = :id');
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':profile_img', $data['profile_img']);
        $this->db->bind(':id', $data['id']);
        $this->db->execute();

    }

    public function insert_token($email, $token){

        $this->db->query('UPDATE users SET token = :token, token_expires = DATE_ADD(NOW(), INTERVAL 5 MINUTE) WHERE email = :email');
        $this->db->bind(':token', $token);
        //$this->db->bind(':token_expires', DATE_ADD(NOW(), INTERVAL 5 MINUTE));
        $this->db->bind(':email', $email);
        $this->db->execute();

    }

    public function delete_token($email, $token){

        $this->db->query("UPDATE users SET token = '' WHERE email = :email");
        $this->db->bind(':email', $email);
        $this->db->execute();
        
    }

    public function find_by_email_and_token($email, $token){

        $this->db->query("SELECT * FROM users WHERE email = :email AND token = :token AND token != '' AND token_expires > NOW()");
        $this->db->bind(':email', $email);
        $this->db->bind(':token', $token);

        $row = $this->db->getSingle();

        if ($this->db->rowCount() > 0) {
            
            return true;
            
        } else {

            return false;

        }

    }

    public function update_password($data){

        $this->db->query("UPDATE users SET password = :password, token = '' WHERE email = :email");
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':email', $data['email']);
        $this->db->execute();

    }

    public function delete_profile($id){

        $this->db->query('DELETE FROM users WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->execute();

    }

}