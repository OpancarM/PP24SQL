<?php

class Product
{
    public static function read()
    {
        $connection = DB::getInstanca();
        $expression = $connection->prepare('
        
        
        '); 
        $expression->execute();
        return $expression->fetchAll();
    }
}