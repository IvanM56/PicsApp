<?php

use PHPMailer\PhpMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once 'Pics.php';

class Users extends Controller {


    public function __construct(){

        $this->user_model = $this->model('User');

    }

    public function register(){

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (CsrfToken::check($_POST['csrf_token'])) {
                
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                Pics::add_profile_img();
                $profile_img = Pics::$new_name;

                $data = [
            
                    'username' => trim($_POST['username']),
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'confirm_password' => trim($_POST['confirm_password']),
                    'profile_img' => $profile_img,
                    'csrf_token' => CsrfToken::create(),
                    'username_error' => '',
                    'email_error' => '',
                    'password_error' => '',
                    'confirm_password_error' => '',
                    'profile_img_error' => ''
                
                ];

                if (empty($data['username'])) {
                    
                    $data['username_error'] = 'Please enter your username';
                
                } else {

                    if($this->user_model->find_by_username($data['username'])){

                        $data['username_error'] = 'This username is already taken';

                    }   

                }
                
                if (empty($data['email'])) {
                    
                    $data['email_error'] = 'Please enter your email';

                } else {

                    if($this->user_model->find_by_email($data['email'])){

                        $data['email_error'] = 'This email is already in use!';

                    }
                }
                
                if (empty($data['password'])) {
                    
                    $data['password_error'] = 'Please enter your password';
                    
                } else {

                    if (strlen($data['password']) < 7){

                        $data['password_error'] = 'Password must be at least 7 characters long';

                    }
                }
                
                if (empty($data['confirm_password'])) {
                    
                    $data['confirm_password_error'] = 'Please confirm your password';
                    
                } else {
            
                    if ($data['confirm_password'] != $data['password']) {
                        
                        $data['confirm_password_error'] = 'Passwords don\'t match!';
            
                    }
                }
                
                if (!$profile_img) {

                    $data['profile_img_error'] = 'Choose only .jpg or .png format!';

                }
                
                if (empty($data['username_error']) && empty($data['email_error']) && empty($data['password_error']) 
                    && empty($data['confirm_password_error']) && empty($data['profile_img_error'])) {
                    
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                    $this->user_model->register($data);
                
                    $_SESSION['profile_img'] = $profile_img;

                    redirect('users/login');
                
                } else {
                
                    $this->view('users/register', $data);
                    
                }

            } 
               
        } else {
        
            $data = [
        
                'username' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'csrf_token' => CsrfToken::create(),
                'username_error' => '',
                'email_error' => '',
                'password_error' => '',
                'confirm_password_error' => ''
            
            ];

            $this->view('users/register', $data);
  
        }

    }


    public function login(){

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (CsrfToken::check($_POST['csrf_token'])){

                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                
                $data = [
            
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'csrf_token' => CsrfToken::create(),
                    'email_error' => '',
                    'password_error' => ''
                
                ];
                
                if (empty($data['email'])) {
                    
                    $data['email_error'] = 'Please enter your email';
                    
                } else {

                    if($this->user_model->find_by_email($data['email'])){

                        // mail je u bazi, user se može ulogirati

                    } else {

                        $data['email_error'] = 'Can\'t find this email in database!';

                    }
                    
                    
                }
                
                if (empty($data['password'])) {
                    
                    $data['password_error'] = 'Please enter your password';
                    
                }
                
                
                if (empty($data['email_error']) && empty($data['password_error'])) {
                    
                    $user = $this->user_model->login($data);
                
                    if($user){

                        if (isset($_POST['remember'])) {
                            
                            setcookie('email', $data['email'], time() + (86400 * 30));
                            setcookie('password', $data['password'], time() + (86400 * 30));

                        } else {
                            
                            if (isset($_COOKIE['email'])) {
                                
                                setcookie('email', '');

                            }

                            if (isset($_COOKIE['password'])) {
                                
                                setcookie('password', '');
                                
                            }
                        
                        }

                        session($user); 

                    } else {

                        $data['password_error'] = 'You have entered wrong password, my boy!';
                        $this->view('users/login', $data);

                    }
                
                } else {
                
                    $this->view('users/login', $data);
                    
                }

            }

        
        } else {
        
            $data = [
        
                'email' => '',
                'password' => '',
                'csrf_token' => CsrfToken::create(),
                'email_error' => '',
                'password_error' => '',
            
            ];
            
            $this->view('users/login', $data);
        
        }

    }

    public function send_email(){

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //$password = PASSWORD;
            //$email = EMAIL;

            if (CsrfToken::check($_POST['csrf_token'])){

                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data = [
    
                    'email' => trim($_POST['email']),
                    'csrf_token' => CsrfToken::create(),
                    'email_msg' => '',
                    'email_error' => ''
    
                ];
    
                $email = $data['email'];
                $user = $this->user_model->find_by_email($email);
    
                if($user){
    
                    $token = random_string();
    
                    $this->user_model->insert_token($email, $token);
    
                    require_once '../app/PHPMailer/PHPMailer.php';
                    require_once '../app/PHPMailer/Exception.php';
                    require_once '../app/PHPMailer/SMTP.php';
    
                    $mail = new PHPMailer;
    
                    // Server
                    //$mail->SMTPDebug = 4;                      
                    $mail->isSMTP();                                            
                    $mail->Host       = 'smtp.gmail.com';                    
                    $mail->SMTPAuth   = true;                                   
                    $mail->Username   = EMAIL;                     
                    $mail->Password   = PASSWORD;                               
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;       
                    $mail->Port       = 587;     
                    // Email
                    $mail->addAddress($email);
                    $mail->setFrom('no_reply@picsapp.com','PicsApp');
                    $mail->Subject = 'Reset Password';
                    $mail->isHTML(true);
                    $mail->Body = "
                            
                        Hi there, <br><br> 
                
                        click on the link below to reset your password.<br><br>

                        <a href='http://localhost:8080/picsapp_mvc/users/reset_password?email=$email&token=$token'>
                        http://localhost:8080/picsapp_mvc/users/reset_password?email=$email&token=$token</a><br><br>

                        Regards,<br> 
                        PicApp
                
                    ";

                    if ($mail->send()) {
                        
                        $data['email_msg'] = 'We\'ve sent you an email. Check your inbox!';
                        
                        $this->view('users/send_email', $data);

                    } else {
                    
                        echo 'Something went wrong!';
                        
                    }  
    
                } else {
    
                    $data['email_msg'] = 'Can\'t find this email in the base!';

                    $this->view('users/send_email', $data);
    
                }

            }

        } else {

            $data = [

                'email' => '',
                'csrf_token' => CsrfToken::create(),
                'email_msg' => '',

            ];

            return $this->view('users/send_email', $data);

        }

        
    }


    public function reset_password(){

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $email = $_COOKIE['email'];
            $token = $_COOKIE['token'];

            if ($this->user_model->find_by_email_and_token($email, $token)){
                
                $data = [

                    'email' => $email,
                    'password' => trim($_POST['password']),
                    'confirm_password' => trim($_POST['confirm_password']),
                    'csrf_token' => CsrfToken::create(),
                    'password_error' => '',
                    'confirm_password_error' => ''

                ];

                if (empty($data['password'])) {
                
                    $data['password_error'] = 'Please enter your password';
                    
                } else {
    
                    if (strlen($data['password']) < 7){
    
                        $data['password_error'] = 'Password must be at least 7 characters long';
    
                    }
                }

                if (empty($data['confirm_password'])) {
                
                    $data['confirm_password_error'] = 'Please confirm your password';
                    
                } else {

                    if($data['password'] != $data['confirm_password']){

                        $data['confirm_password_error'] = 'Passwords don\'t match!';

                    }
                }

                if(empty($data['password_error']) && empty($data['confirm_password_error'])){

                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                    $this->user_model->update_password($data);  
                
                    unset($_COOKIE['email']);
                    unset($_COOKIE['token']);

                    redirect('users/login');

                } else {

                    return $this->view('users/reset_password', $data);

                }

            } else {

                // flash('Invalid or expired token!');
                $this->user_model->delete_token($email, $token);
                unset($_COOKIE['email']);
                unset($_COOKIE['token']);
                return $this->view('users/send_email');

            }

        } else if (isset($_GET['email']) && isset($_GET['token'])){

            $email = $_GET['email'];
            $token = $_GET['token'];

            if($this->user_model->find_by_email_and_token($email, $token)){

                setcookie('email', $email);
                setcookie('token', $token);

                $data = ['csrf_token' => CsrfToken::create()];

                return $this->view('users/reset_password', $data);

            } else {

                redirect('home');

            }

        } else {

            redirect('home');

        }

    }


    public function profile($id){

        $user = $this->user_model->get_user_and_pic_count($id);

        $data = [

            'username' => $user->username,
            'email' => $user->email,
            'profile_img' => $user->profile_img,
            'pic_count' => $user->pic_count

        ];

        return $this->view('users/profile', $data);

    }


    public function edit_profile($id){
        

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (CsrfToken::check($_POST['csrf_token'])){

                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $user = $this->user_model->get_user($id);
                
                if (isset($_FILES)) {

                    Pics::upd_profile_img($user->profile_img);
                    $profile_img = Pics::$new_name;

                } 
    
                $data = [
    
                    'id' => $id,
                    'username' => trim($_POST['username']),
                    'email' => trim($_POST['email']),
                    'csrf_token' => CsrfToken::create(),
                    'profile_img' => $profile_img,
                    'username_error' => '',
                    'email_error' => '',
                    'profile_img_error' => ''
    
                ];
    
    
                if (empty($data['username'])) {
            
                    $data['username_error'] = 'Enter your new username';
    
                } 
    
    
                if (empty($data['email'])) {
                
                    $data['email_error'] = 'Enter your new email';
                    
                } else {
    
                    if($this->user_model->find_by_email($data['email'])){
    
                        if($data['email'] == $user->email){
    
                            // Pass
    
                        } else {
    
                            $data['email_error'] = 'This email is already in use!';
    
                        }    
    
                    }
                    
                }

                if (!$profile_img) {
                    
                    $data['profile_img_error'] = 'Choose only .jpg. or png. format!';

                } 
    
                if (empty($data['username_error']) && empty($data['email_error']) && empty($data['profile_img_error'])) {
                    
                    $this->user_model->update($data);

                    $_SESSION['username'] = $data['username'];
                    $_SESSION['profile_img'] = $profile_img;      

                    redirect('users/profile/'. $id);

                } else {
    
                    $this->view('users/edit_profile', $data);
    
                }

            }  

        } else {

            $user = $this->user_model->get_user($id);

            if($user->id != $_SESSION['id']){

                redirect('home');

            } else {

                $data = [

                    'id' => $id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'profile_img' => $user->profile_img,
                    'csrf_token' => CsrfToken::create(),
                    'username_error' => '',
                    'email_error' => '',
                    'profile_img_error'
        
                ];
                
                return $this->view('users/edit_profile', $data);

            }
            

        }

    }



    public function delete_profile($id){

        // prvo treba provjeriti ima li user uopće ikakvu fotku u bazi
        // ako nema ide DELETE iz users tablice
        // ako ima ide DELETE users JOIN images
        // al prvo treba iz storagea maknuti fotke
        // i onda iz baze

        if ($id !== $_SESSION['id']) {
            
            redirect('home');

        } else {

            $user_data = $this->user_model->get_user_and_pics($id);

            foreach ($user_data as $key => $value) {
                
                if ($value->profile_img != 'default.jpg') {
                    
                    unlink('../public/assets/img/profile_pics/'. $value->profile_img);

                }

                unlink('../public/assets/img/'. $value->img_name);
               
            }

            $this->user_model->delete_profile($id);

            $this->logout();

        }
        
        

    }

    public function logout(){
    
        unset($_SESSION['id']);
        unset($_SESSION['email']);
        unset($_SESSION['username']);
    
        session_destroy();
    
        redirect('home');
    
    }

}
