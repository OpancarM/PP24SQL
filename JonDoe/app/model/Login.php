<?php

class Login
{
    public static function authorization($email, $password)
    {
        $connection = DB::getInstance();

        $query = $connection->prepare('
            select * from user where email=:email
        ');
        $query->execute(['email' => $email]);

        $operator = $query->fetch();

        if ($operator == null) {
            $query = $connection->prepare('
            select * from operator where email=:email
            ');
            $query->execute(['email' => $email]);

            $operator = $query->fetch();
        }

        if ($operator == null){
            return null;
        }

        if (!password_verify($password, $operator->user_password)){
            return null;
        }

        unset($operator->user_password);
        return $operator;
    }
}