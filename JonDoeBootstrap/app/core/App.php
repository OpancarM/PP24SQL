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

        $parameter1=null;
        if(!isset($parts[3]) || $parts[3]===''){
            $parameter1=null;
        }else{
            $parameter1=$parts[3];
        }

        $parameter2=null;
        if(!isset($parts[4]) || $parts[4]===''){
            $parameter2=null;
        }else{
            $parameter2=$parts[4];
        }

        

        if(class_exists($class) && method_exists($class,$method)){
            $instance = new $class();
            if($parameter1==null){
                $instance->$method();
            }else{
                if($parameter2==null){    
                $instance->$method($parameter1);
                }else{
                    $instance->$method($parameter1,$parameter2);
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