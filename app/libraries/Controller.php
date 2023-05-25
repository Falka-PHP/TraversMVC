<?php

class Controller {
    // Load model
    public function model($model){
        //require module file
        require_once('../app/models/'.$model.'.php');
        return new $model();
    }

    public function view($view, $data = []){
        //Check for a new file
        if(file_exists('../app/views/' . $view . '.php')){
            require_once '../app/views/' . $view . '.php';
        }else{
            die('View does not exist');
        }
    }

}