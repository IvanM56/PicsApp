<?php

namespace App\Controllers;

use \Core\View;
use App\Models\User;
use App\Models\Pic;


class Home extends \Core\Controller {
    

    public function index(){

        $pics = Pic::getAll();

        View::render('Home/index', [
            'pics' => $pics
        ]);

    }

    
}