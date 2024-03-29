<?php

/* App Core Class
Creates URL & loads core controller
URL FORMAT - /controller/method/params
*/

class Core{
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct(){
        
        $url = $this->getUrl();

        if($url != null && file_exists('../app/controllers/' . ucwords($url[0]) . '.php')){
            //If exist, set as controller
            $this->currentController = ucwords($url[0]);
            //Unset 0 index
            unset($url[0]);
        }

        //Require the controller
        require_once '../app/controllers/' . $this->currentController . '.php';

        //Instance controller class
        $this->currentController = new $this->currentController;

        //Check for secound part of url
        if(isset($url[1])){
            if(method_exists($this->currentController, $url[1])){
                $this->currentMethod = $url[1]; 
                unset($url[1]);
            }
        }

        $this->params = $url ? array_values($url) : [];

        //Call a callback with arrays of params
        call_user_func_array([$this->currentController,
        $this->currentMethod,], $this->params);


    }

    public function getUrl(){
        if(isset($_GET['url'])){
            $url = rtrim($_GET['url'],'/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
        
    } 
}