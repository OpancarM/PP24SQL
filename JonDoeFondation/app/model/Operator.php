<?php

class Operator
{

    public static function authorization($email, $password)
    {
        $connection = DB::getInstance();

        
        $query = $connection->prepare('

            select * from operator 
            where email=:email

        ');

        $query->execute(['email' => $email]);

        $operator = $query->fetch();

        if ($operator == null) {
            $connection->beginTransaction();
            $query = $connection->prepare('

                select * from customer 
                where email=:email

            ');

            $query->execute(['email' => $email]);

            $operator = $query->fetch();
    
        }

        if ($operator == null){
            return null;
        }

        if (!password_verify($password, $operator->userpassword)){
            return null;
        }

        unset($operator->userpassword);
        return $operator;
    }
}

