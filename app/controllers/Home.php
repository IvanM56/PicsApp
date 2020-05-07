<?php

class Home extends Controller {


    public function __construct(){

        $this->pics_model = $this->model('Pic');

    }

    public function index(){

        $pics = $this->pics_model->all_pics();

        $data = [

            'pics' => $pics,

        ];
   
        print_r($_COOKIE);
        echo "<br>";
        print_r($_SESSION);
        
        return $this->view('home', $data);

    }

}