<?php

namespace App\Controllers;

use \Core\View;
use App\Auth;
use App\Models\Pic;
use App\Controllers\Users;
use App\Helpers\Redirect;
use App\Helpers\Session;


class Pics extends \Core\Controller {


    public static $new_name;


    public function index(){

        $pics = Pic::getAll();

        View::render('Pics/index', [
            'pics' => $pics
        ]);

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

        if(Auth::loggedIn()){

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $upload_path = '../public/img/';
            
                $filename = $_FILES['pic']['name'];
                $tmpname = $_FILES['pic']['tmp_name'];
                $error = $_FILES['pic']['error'];
                $size = $_FILES['pic']['size'];  

                if ($error == UPLOAD_ERR_OK && $size != 0 && $size <= 5242880) {

                    $path = pathinfo($filename);
                    $ext = strtolower($path['extension']);
                    $new_name = time(). '.' .$ext;
                    $valid_extentions = ['jpg', 'jpeg', 'png'];
    
                    if (in_array($ext, $valid_extentions)) {
                         
                        /* RESIZE */

                        $image_properties = getimagesize($tmpname);
                        $img_type = $image_properties[2];

                        switch ($img_type) {
                            case IMAGETYPE_JPEG:
                                $original_img = imagecreatefromjpeg($tmpname);
                                $tmp = $this->resizeImg($original_img, $image_properties[0], $image_properties[1], '700');
                                imagejpeg($tmp, $upload_path.$new_name);

                                //move_uploaded_file($tmpname, $upload_path.$new_name);
                                break;
                            
                            case IMAGETYPE_PNG:
                                $original_img = imagecreatefrompng($tmpname);
                                $resized_img = $this->resizeImg($original_img, $image_properties[0], $image_properties[1], '700');
                                imagepng($resized_img, $upload_path.$new_name);

                                //move_uploaded_file($tmpname, $upload_path.$new_name);
                                break;

                        }

                        /* RESIZE ENDS */

                        Pic::add_pic(Session::get('id'), $new_name);
    
                        Redirect::to('pics/index');
    
                    } else {
                        Redirect::to('home');
                    }  
            
                } else {   
                    Redirect::to('home');
                }  
            } 

        } else {
            Redirect::to('home');
        }       
   }

   public function resizeImg($original_img, $original_width, $original_height, $max_res){

        $ratio = $max_res / $original_width;
        $new_width = $max_res;
        $new_height = $original_height * $ratio;

        if ($new_height > $max_res) {
            $ratio = $max_res / $original_height;
            $new_height = $max_res;
            $new_width = $original_width * $ratio;
        }
        
        $new_img = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($new_img, $original_img, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);

        return $new_img;
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

            if ($pic->user_id != Session::get('id')) {
                
                Redirect::to('home');

            } else {

                if ($pic) {
                    // Remove from storage
                    unlink('../public/img/'. $pic->img_name);
        
                } else {
        
                    echo 'Something went wrong!';
        
                }
                // Delete from database
                Pic::delete_pic($id, Session::get('id'));
                
                Redirect::to('pics/index');

            }
        }
        
    }

}