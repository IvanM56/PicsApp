<?php

namespace App\Controllers;

use \Core\View;
use App\Models\User;
use App\Helpers\CsrfToken;
use App\Config;
use Vendor\PHPMailer\PHPMailer;
use Vendor\PHPMailer\Exception;
use Vendor\PHPMailer\SMTP; 
use App\Helpers\Redirect;
use App\Helpers\Session;
use App\Helpers\RandomString;
use App\Helpers\Validation;


class Users extends \Core\Controller {


    public function index(){

        $users = User::getAll();
        View::render('Users/index', [
            'users' => $users
        ]);

    }


    public function register(){

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (CsrfToken::check($_POST['csrf_token'])) {
                
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                Pics::addProfileImg();
                $profile_img = Pics::$new_name;

                $data = [
            
                    'username' => trim($_POST['username']),
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'confirm_password' => trim($_POST['confirm_password']),
                    'profile_img' => $profile_img,
                    'csrf_token' => CsrfToken::create(),
                    'profile_img_error' => ''
                
                ];

                Validation::check([

                    'username' => [
                        'required' => true,
                        'unique' => true,
                        'min' => 2,
                        'max' => 25
                    ],
                    'email' => [
                        'required' => true,
                        'unique' => true,
                    ],
                    'password' => [
                        'required' => true,
                        'min' => 7
                    ],
                    'confirm_password' => [
                        'required' => true,
                        'matches' => 'password'
                    ],

                ]); 
             
                if (!$profile_img) {

                    $data['profile_img_error'] = 'Choose only .jpg or .png format!';

                }

                if (Validation::passed()) {

                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                    User::register($data);
                    $_SESSION['profile_img'] = $profile_img;

                    Redirect::to('users/login');

                } else {

                    View::render('users/register', [
                        'data' => $data
                    ]);

                }
            } 
               
        } else {
        
            $data = [
        
                'username' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'csrf_token' => CsrfToken::create(),
            
            ];

            View::render('users/register', [
                'data' => $data
            ]);
  
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
                
                ];
                
                Validation::check([

                    'email' => [
                        'required' => true,
                        'exists' => true
                    ],
                    'password' => [
                        'required' => true
                    ]

                ]); 

                if (Validation::passed()) {
                    
                    $user = User::login($data);

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

                        Session::set('id', $user->id);
                        Session::set('email', $user->email);
                        Session::set('username', $user->username);
                        Session::set('profile_img', $user->profile_img);

                        Redirect::to('home');

                    } else {

                        $data['login_error'] = 'Wrong password! Login failed!';
                        View::render('users/login', [
                            'data' => $data
                        ]);

                    }
                    
                } else {

                    $data['password_error'] = 'You have entered wrong password!';
                    View::render('users/login', [
                        'data' => $data
                    ]);

                }

            }

        } else {
        
            $data = [
        
                'email' => '',
                'password' => '',
                'csrf_token' => CsrfToken::create()
            
            ];
            
            View::render('users/login', [
                'data' => $data
            ]);
        
        }

    }


    public function sendEmail(){

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (CsrfToken::check($_POST['csrf_token'])){

                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data = [
    
                    'email' => trim($_POST['email']),
                    'csrf_token' => CsrfToken::create(),
                    'email_msg' => '',
                    'email_error' => ''
    
                ];
    
                $email = $data['email'];
                $user = User::find_by_email($email);
    
                if($user){
    
                    $token = RandomString::create();
    
                    User::insert_token($email, $token);
    
                    $mail = new PHPMailer;
    
                    /* Server */
                    //$mail->SMTPDebug = 4;                      
                    $mail->isSMTP();                                            
                    $mail->Host       = 'smtp.gmail.com';                    
                    $mail->SMTPAuth   = true;                                   
                    $mail->Username   = Config::EMAIL_ADDRESS;                     
                    $mail->Password   = Config::EMAIL_PASSWORD;                               
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;       
                    $mail->Port       = 587;     
                    /* Email */
                    $mail->addAddress($email);
                    $mail->setFrom('no_reply@picsapp.com','PicsApp');
                    $mail->Subject = 'Reset Password';
                    $mail->isHTML(true);
                    $mail->Body = "
                            
                        Hi there, <br><br> 
                
                        click on the link below to reset your password.<br><br>

                        <a href='http://localhost:8080/picsapp_mvc/users/reset-password?email=$email&token=$token'>
                        http://localhost:8080/picsapp_mvc/users/reset-password?email=$email&token=$token</a><br><br>

                        Regards,<br> 
                        PicApp
                
                    ";

                    if ($mail->send()) {
                        
                        $data['email_msg'] = 'We\'ve sent you an email. Check your inbox!';
                        
                        View::render('users/send_email', [
                            'data' => $data
                        ]);

                    } else {
                    
                        echo 'Something went wrong!';
                        
                    }  
    
                } else {
    
                    $data['email_error'] = 'Can\'t find this email in the base!';

                    View::render('users/send_email', [
                        'data' => $data
                    ]);
    
                }

            }

        } else {

            $data = [

                'email' => '',
                'csrf_token' => CsrfToken::create(),
                'email_msg' => '',

            ];

            return View::render('users/send_email', [
                'data' => $data
            ]);

        }
   
    }


    public function resetPassword(){

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $email = $_COOKIE['email'];
            $token = $_COOKIE['token'];

            if (User::find_by_email_and_token($email, $token)){
                
                $data = [

                    'email' => $email,
                    'password' => trim($_POST['password']),
                    'confirm_password' => trim($_POST['confirm_password']),
                    'csrf_token' => CsrfToken::create(),
                    'password_error' => '',
                    'confirm_password_error' => ''

                ];

                Validation::check([

                    'password' => [
                        'required' => true,
                        'min' => 7
                    ],
                    'confirm_password' => [
                        'required' => true,
                        'matches' => 'password'
                    ],

                ]); 

                if (Validation::passed()) {
                    
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                    User::update_password($data);

                    unset($_COOKIE['email']);
                    unset($_COOKIE['token']);

                    Redirect::to('users/login');

                } else {

                    return View::render('users/reset_password', [
                        'data' => $data
                    ]);

                }

            } else {

                // flash('Invalid or expired token!');
                User::delete_token($email, $token);
                unset($_COOKIE['email']);
                unset($_COOKIE['token']);
                return View::render('users/send_email');

            }

        } else if (isset($_GET['email']) && isset($_GET['token'])){

            $email = $_GET['email'];
            $token = $_GET['token'];

            if(User::find_by_email_and_token($email, $token)){

                setcookie('email', $email);
                setcookie('token', $token);

                $data = ['csrf_token' => CsrfToken::create()];

                return View::render('users/reset_password', [
                    'data' => $data
                ]);

            } else {

                Redirect::to('home');

            }

        } else {

            Redirect::to('home');

        }

    }


    public function profile(){

        $id = $this->route_params['id'];
       
        $user = User::get_user($id);

        $data = [

            'username' => $user->username,
            'email' => $user->email,
            'profile_img' => $user->profile_img,
            'pic_count' => $user->pic_count

        ];

        return View::render('users/profile', [
            'data' => $data
        ]);

    }


    public function editProfile(){

        $id = $this->route_params['id'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (CsrfToken::check($_POST['csrf_token'])){

                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $user = User::get_user($id);
                
                if (isset($_FILES)) {

                    Pics::updProfileImg($user->profile_img);
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
    
                    if(User::find_by_email($data['email'])){
    
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
                    
                    User::update($data);

                    Session::set('username', $data['username']);
                    Session::set('profile_img', $data['profile_img']);         

                    Redirect::to('users/profile/'. $id);

                } else {
    
                    View::render('users/edit_profile', [
                        'data' => $data
                    ]);
    
                }

            }  

        } else {

            $user = User::get_user($id);

            if($user->id != Session::get('id')){

                Redirect::to('home');

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
                
                return View::render('users/edit_profile', [
                    'data' => $data
                ]);

            }
            
        }

    }

    public function deleteProfile(){

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $id = $_POST['userId'];

            if ($id !== Session::get('id')) {
                
                Redirect::to('home');
    
            } else {
    
                $user_data = User::get_user_and_pics($id);
    
                foreach ($user_data as $key => $value) {
                    
                    if ($value->profile_img != 'default.jpg') {
                        
                        unlink('../public/img/profile_pics/'. $value->profile_img);
    
                    }
    
                    unlink('../public/img/'. $value->img_name);
                   
                }
    
                User::delete_profile($id);
    
                $this->logout();
    
            } 

        }    

    }

    public static function loggedIn(){

        if (Session::exists('id')) {
            
            return true;

        } else {

            return false;

        }

    }

    public function logout(){
    
        Session::delete('id');
        Session::delete('email');
        Session::delete('username');
    
        session_destroy();
    
        Redirect::to('home');
    
    }
}