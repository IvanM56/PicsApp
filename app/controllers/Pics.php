<?php

class Pics extends Controller {


    public static $new_name;


    public function __construct(){

        $this->pics_model = $this->model('Pic');

    }


   public function user_pics($user_id){

        $pics = $this->pics_model->user_pics($user_id);

        $data = [

            'pics' => $pics

        ];

        $this->view('pics/user_pics', $data);

   }

   public function add_pic(){

        if(logged_in()){

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $upload_path = '../public/assets/img/';
            
                $filename = $_FILES['pic']['name'];
                $tmpname = $_FILES['pic']['tmp_name'];
                $error = $_FILES['pic']['error'];
                $size = $_FILES['pic']['size'];
                
                if ($error == UPLOAD_ERR_OK && $size != 0 && $size <= 5242880) {
            
                    $path = pathinfo($filename);
                    $ext = strtolower($path['extension']);
    
                    $valid_ext = ['jpg', 'jpeg', 'png'];
    
                    if (in_array($ext, $valid_ext)) {
                        
                        $new_name = time(). '.' .$ext;
                        $destfile = $upload_path.$new_name;
                
                        move_uploaded_file($tmpname, $destfile);
    
                        $this->pics_model->add_pic($_SESSION['id'], $new_name);
    
                        redirect('home');
    
                    } else {
    
                        $data = ['pic_error' => 'Only .jpg and .png, sorry!'];
    
                        $this->view('pics/add_pic', $data);
    
                    }  
            
                } else {
            
                    $data = ['pic_error' => 'Choose some file to upload!'];
    
                    $this->view('pics/add_pic', $data);
            
                }
            
                // header("Location: show_user.php");
            
            } else {
    
                return $this->view('pics/add_pic');
    
            } 

        } else {

            redirect('home');

        }
          
 
   }

   static function add_profile_img(){
        
        $upload_path = '../public/assets/img/profile_pics/';
    
        $filename = $_FILES['profile_pic']['name'];
        $tmpname = $_FILES['profile_pic']['tmp_name'];
        $error = $_FILES['profile_pic']['error'];
        $size = $_FILES['profile_pic']['size'];

        if ($error == UPLOAD_ERR_OK && $size != 0 && $size <= 5242880) {

            $path = pathinfo($filename);
            $ext = strtolower($path['extension']);

            $valid_ext = ['jpg', 'jpeg', 'png'];
           
            if (in_array($ext, $valid_ext)){

                self::$new_name = time(). '.' .$ext;
                $destfile = $upload_path.self::$new_name;

                move_uploaded_file($tmpname, $destfile);

            } 

        } else {

            self::$new_name = 'default.jpg';

        }

   }

   static function upd_profile_img($img){

        $upload_path = '../public/assets/img/profile_pics/';

        $filename = $_FILES['upd_profile_pic']['name'];
        $tmpname = $_FILES['upd_profile_pic']['tmp_name'];
        $error = $_FILES['upd_profile_pic']['error'];
        $size = $_FILES['upd_profile_pic']['size'];

        if ($error == UPLOAD_ERR_OK && $size != 0 && $size <= 5242880) {

            $path = pathinfo($filename);
            $ext = strtolower($path['extension']);

            $valid_ext = ['jpg', 'jpeg', 'png'];

            if (in_array($ext, $valid_ext)){

                self::$new_name = time(). '.' .$ext;
                $destfile = $upload_path.self::$new_name;

                if($img != 'default.jpg'){

                    unlink('../public/assets/img/profile_pics/'. $img);
        
                }

                move_uploaded_file($tmpname, $destfile);

            } 

        } else {

            self::$new_name = $img;

        }   

    }

   public function remove_pic($id){

        $pic = $this->pics_model->get_img($id);

        if ($pic->user_id != $_SESSION['id']) {
            
            redirect('home');

        } else {

            if ($pic) {
    
                // Remove from storage
                unlink('../public/assets/img/'. $pic->img_name);
    
            } else {
    
                echo 'Something went wrong!';
    
            }
    
            // Delete from database
            $this->pics_model->delete_pic($id);
            
            redirect('home');

        }     
        
   }

}