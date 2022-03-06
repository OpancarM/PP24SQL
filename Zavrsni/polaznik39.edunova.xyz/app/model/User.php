<?php

class User
{
    public static function authorize($email,$password)
    {
        $connect = DB::getInstance();
        $expression = $connect->prepare('
        
        select * from user where email=:email;
        
        ');
        $expression->execute(['email'=>$email]);
        $user = $expression->fetch();
        if($user==null){
            return null;
        }
        if(!password_verify($password,$user->password)){
            return null;
        }
        unset($user->password);
        return $user;
    }
}