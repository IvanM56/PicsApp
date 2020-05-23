<?php

namespace App\Controllers;

use \Core\View;
use App\Models\Pic;


class Pics extends \Core\Controller {


    public static $new_name;


    public function index(){

        echo 'Hello from Pics controller';
        echo '<p>Route parameters: <pre>' .
                htmlspecialchars(print_r($this->route_params, true)) . '</pre></p>';
                echo $this->route_params['id'];

    }


   public function userPics(){

        $user_id = $this->route_params['id'];

        $pics = Pic::user_pics($user_id);

        $data = [

            'pics' => $pics

        ];

        View::render('pics/user_pics', [
            'data' => $data
        ]);

   }

   public function addPic(){

        if(logged_in()){

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $upload_path = '../public/img/';
            
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
    
                        Pic::add_pic($_SESSION['id'], $new_name);
    
                        redirect('home');
    
                    } else {
    
                        $data = ['pic_error' => 'Only .jpg and .png, sorry!'];
    
                        View::render('pics/add_pic', [
                            'data' => $data
                        ]);
    
                    }  
            
                } else {
            
                    $data = ['pic_error' => 'Choose some file to upload!'];
    
                    View::render('pics/add_pic', [
                        'data' => $data
                    ]);
            
                }
            
            } else {
    
                return View::render('pics/add_pic');
    
            } 

        } else {

            redirect('home');

        }
          
 
   }

   static function addProfileImg(){
        
        $upload_path = '../public/img/profile_pics/';
    
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

   static function updProfileImg($img){

        $upload_path = '../public/img/profile_pics/';

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

                    unlink('../public/img/profile_pics/'. $img);
        
                }

                move_uploaded_file($tmpname, $destfile);

            } 

        } else {

            self::$new_name = $img;

        }   

    }

   public function removePic(){

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $id = $_POST['picId'];
          
             // $id = $this->route_params['id'];

            $pic = Pic::get_pic($id);

            if ($pic->user_id != $_SESSION['id']) {
                
                redirect('home');

            } else {

                if ($pic) {
                    // Remove from storage
                    unlink('../public/img/'. $pic->img_name);
        
                } else {
        
                    echo 'Something went wrong!';
        
                }
                // Delete from database
                Pic::delete_pic($id, $_SESSION['id']);
                
                redirect('home');

            }
        }
        
    }

}