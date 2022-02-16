<?php

class App
{
    public static function start()
    {
        $route = Request::getRoute();

        $parts = explode('/',$route);

        $class='';
        if(!isset($parts[1]) || $parts[1]===''){
            $class='Index';
        }else{
            $class=ucfirst($parts[1]);
        }
        $class .= 'Controller';

        $method='';
        if(!isset($parts[2]) || $parts[2]===''){
            $method='index';
        }else{
            $method=$parts[2];
        }

        if(class_exists($class) && method_exists($class,$method)){
            $instance = new $class();
            $instance->$method();
        }else{
            echo $class . '->' . $method . '() do not exist';
        }
    }
    public static function config($key)
    {
        $config = include BP_APP . 'configuration.php';
        return $config[$key];
    }
}