<?php

namespace App\Controllers; 

use \Core\View;
use App\Auth;
use App\Models\Pic;


class Home extends \Core\Controller {
    

    public function index(){

        View::render('Home/index', [
            'user' => Auth::getUser()
        ]);

    }

    
}