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

        $param1=null;
        if(!isset($parts[3]) || $parts[3]===''){
            $param1=null;
        }else{
            $param1=$parts[3];
        }

        $param2=null;
        if(!isset($parts[4]) || $parts[4]===''){
            $param2=null;
        }else{
            $param2=$parts[4];
        }

        if(class_exists($class) && method_exists($class,$method)){
            $instance = new $class();
            if($param1==null){
                $instance->$method();
            }else{
                if($param2==null){    
                $instance->$method($param1);
                }else{
                    $instance->$method($param1,$param2);
                }
            }    
        }else{
            $view = new View();
            $view->render('error404',[
                'donotexist' =>$class . '->' . $method
            ]);
        }
    }
    
    public static function config($key)
    {
        $config = include BP_APP . 'configuration.php';
        return $config[$key];
    }

    public static function authorized()
    {
        if(isset($_SESSION) && isset($_SESSION['authorized'])){
            return true;
        }

        return false;
    }

    public static function admin()
    {
        if(App::authorized() && $_SESSION['authorized']->operatorrole==='admin'){
            return true;
        }

        return false;
    }

    
}