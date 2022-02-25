<?php

class Operator
{
    public static function authorize($email,$password)
    {
        $connect = DB::getInstance();
        $expression = $connect->prepare('
        
        select * from operator where email=:email;
        
        ');
        $expression->execute(['email'=>$email]);
        $operator = $expression->fetch();
        if($operator==null){
            return null;
        }
        if(!password_verify($password,$operator->password)){
            return null;
        }
        unset($operator->password);
        return $operator;
    }
}