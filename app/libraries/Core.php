<?php

class Core {

    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];

    public function __construct(){

        $url = $this->getURL();

        // print_r($url);

        if (file_exists('../app/controllers/'. ucwords($url[0]) .'.php')) {
            
            $this->controller = ucwords($url[0]);

            unset($url[0]);
        }
        
        // Require controller
        require_once '../app/controllers/'. $this->controller .'.php';

        // Instantiate the controller class
        $this->controller = new $this->controller;


        // Dealing methods inside controller class
        if (isset($url[1])) {
            
            if (method_exists($this->controller, $url[1])) {

                $this->method = $url[1];

                unset($url[1]);
            }
        }
        
        // Get params
        $this->params = $url ? array_values($url) : [];
        //print_r($this->params);

        // Call a callback with array of params
        call_user_func_array([$this->controller, $this->method], $this->params);


    }

    public function getURL(){

        if (isset($_GET['url'])) {
            
            $url = rtrim($_GET['url'], '/');
            $url = explode('/', $url);
            // dodati SANITIZE!!!

            return $url;
        }
        


    }

}