<?php

class DB extends PDO
{
    private static $instance=null;

    private function __construct($data)
    {
        $dsn='mysql:host=' . $data['server'] . ';dbname=' . $data['data'] . ';charset=utf8mb4';
        parent::__construct($dsn,$data['user'],$data['password']);
        
        $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
    }

    public static function getInstance()
    {
        if(self::$instance==null){
            self::$instance=new self(App::config('data'));        
        }
        return self::$instance;
    }
}