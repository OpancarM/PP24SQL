<?php

class App
{
    public static function start()
    {
        
        $ruta = Request::getRuta();

        $djelovi = explode('/',$ruta);

        $klasa='';
        if(!isset($djelovi[1]) || $djelovi[1]===''){
            $klasa='Index';
        }else{
            $klasa=ucfirst($djelovi[1]);
        }
        $klasa .= 'Controller';

        $metoda='';
        if(!isset($djelovi[2]) || $djelovi[2]===''){
            $metoda='index';
        }else{
            $metoda=$djelovi[2];
        }

        $parametar1=null;
        if(!isset($djelovi[3]) || $djelovi[3]===''){
            $parametar1=null;
        }else{
            $parametar1=$djelovi[3];
        }

        $parametar2=null;
        if(!isset($djelovi[4]) || $djelovi[4]===''){
            $parametar2=null;
        }else{
            $parametar2=$djelovi[4];
        }


        if(class_exists($klasa) && method_exists($klasa,$metoda)){
            $instanca = new $klasa();
            if($parametar1==null){
                $instanca->$metoda();
            }else{
                if($parametar2==null){
                    $instanca->$metoda($parametar1);
                }else{
                    $instanca->$metoda($parametar1,$parametar2);
                }
                
            }
            
        }else{
       
            $view = new View();
            $view->render('error404',[
                'onoceganema' =>$klasa . '->' . $metoda
            ]);

        }

    }

    public static function config($kljuc)
    {
        $config = include BP_APP . 'konfiguracija.php';
        return $config[$kljuc];
    }
    public static function autoriziran()
    {
        if(isset($_SESSION) && isset($_SESSION['autoriziran'])){
            return true;
        }

        return false;
    }

    public static function admin()
    {
        if(App::autoriziran() && $_SESSION['autoriziran']->uloga==='admin'){
            return true;
        }

        return false;
    }
}