<?php

class Cart{

	public static function read()
    {
        $cennection = DB::getInstance();
        $izraz = $veza->prepare('
        
            select * from product
        
        '); 
        $izraz->execute();
        return $izraz->fetchAll();
    }
}