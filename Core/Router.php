<?php

namespace Core;

class Router {

    // the routing table
    protected $routes = [];

    // parameters from the matched route
    protected $params = [];


    // add a route to the routing table
    public function add($route, $params = []){

        // Convert the route to a regular expression: escape forward slashes
        $route = preg_replace('/\//', '\\/', $route);

        // Convert variables, such as {controller}
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);

        // Convert variables, with custom regular expressions, such as {controller}
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);

        // Add start and end delimiters, and case insensitive flag
        $route = '/^'. $route .'$/i'; 

        $this->routes[$route] = $params;
    }


    // get all the routes from the routing table
    public function getRoutes(){

        return $this->routes;
    }

    // match the route to the routes in the routing table, setting the $params 
    // property if a route is round
    public function match($url){

        foreach ($this->routes as $route => $params) {
           
            if (preg_match($route, $url, $matches)) {
       
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }
                
                $this->params = $params;
                return true;
            }
        }
        
        // if it doesn't find a match, obviously:
        return false;

    }


    public function dispatch($url){
        
        //remove variables from url before matching
        $url = $this->removeQueryStringVariables($url);

        if ($this->match($url)) {
            $controller = $this->params['controller'];
            $controller = $this->convertToStudlyCaps($controller);
            // $controller = "App\Controllers\\$controller";  // zašto dva backslasha?
            $controller = $this->getNamespace() . $controller;

          
            if (class_exists($controller)) {
                $controller_object = new $controller($this->params);

                $action = $this->params['action'];
                $action = $this->convertToCamelCase($action);

                if (is_callable([$controller_object, $action])) {
                    $controller_object->$action();
                } else {
                    echo "Method $action (in controller $controller) not found";
                }

                // call_user_func_array([$controller_object, $action], $this->params);

            } else {
                echo "Controller class $controller not found";
            }

        } else {
            echo 'No route matched';

        }
    
    }

    protected function convertToStudlyCaps($string){
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    protected function convertToCamelCase($string){
        return lcfirst($this->convertToStudlyCaps($string));
    }


    protected function removeQueryStringVariables($url){

        if ($url != '') {
            $parts = explode('&', $url, 2);  // 2 je ograničenje elemenata u arrayu

            if (strpos($parts[0], '=') === false) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }

        return $url;
    }

    // to organize controllers inside folders
    // namespace Admin\Users, ili bilo koji drugi subdirektorij
    // iz front controllera index.php: $router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);
    protected function getNamespace(){

        $namespace = 'App\Controllers\\';

        if (array_key_exists('namespace', $this->params)) {
            $namespace .= $this->params['namespace'] . '\\';
        }

        return $namespace;
    }

    // get params
    /*public function getParams(){

        return $this->params;
    }*/

}