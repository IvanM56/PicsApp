<?php

namespace Core;

// neće se izravno instancirati u objekte, zato je abstract
// bitan je zato da svim controllerima budu dostupni parametri iz url-ova, id-evi konkretno
// to access route parameters in controllers
abstract class Controller {

    protected $route_params = [];

    public function __construct($route_params){

        $this->route_params = $route_params;
        
    }


    // tzv. action filters
    public function __call($name, $args){

        $method = $name . 'Action';

        if (method_exists($this, $method)) {
            if ($this->before() !== false) {
                call_user_func_array([$this, $method], $args);
                $this->after();
            }
        } else {
            echo "Method $method not found in controler ". get_class($this);
        }


    }

    protected function before(){

    }

    protected function after(){
        
    }
}