<?php
class Customer
{
    public static function authorization($email, $password)
    {
        $connection = DB::getInstance();

        $query = $connection->prepare('
        
        select * from customer where email=:email;
        
        ');
        $query->execute(['email'=>$email]);
        $customer = $query->fetch();
        if($customer==null){
            return null;
        }
        if(!password_verify($password,$customer->userpassword)){
            return null;
        }
        unset($customer->userpassword);
        return $customer;
    }

    public static function readOne($key)
    {
        $connection = DB::getInstance();
        $query = $connection->prepare('
        
        select * from customer where id=:parameter;
        
        ');
        $query->execute(['id' => $id]);
        return  $query->fetchAll();
    }

    public static function read()
    {
        $connection = DB::getInstance();
        $query = $connection->prepare('
        
        select a.id a.email, a.userpassword,a.firstname,a.lastname,
        count(b.id) as cart
        from customer a left join cart b
        on a.id = b.customer 
        group by a.id a.email, a.userpassword,a.firstname,a.lastname;
        
        ');
        $query->execute();
        return  $query->fetch();
    }

    public static function create($parameter)
    {
        $connection = DB::getInstance();
        $query = $connection->prepare('
        
                insert into customer (email,userpassword,firstname,lastname)
                values (:email, :userpassword, :firstname, :lastname);
        
        ');
        $query->execute($parameter);
    } 
    
    public static function update($parameter)
    {
        $connection = DB::getInstance();
        $query = $connection->prepare('
            
        update customer set 
        email=:email,
        userpassword=:userpassword,
        firstname=:firstname,
        lastname=:lastname,
        where id=:id;
        ');
        
        $query->execute($parameter);
    }  

    public static function delete($id)
    {
        $connection = DB::getInstance();
        $query = $connection->prepare('
        
        delete from customer where id=:id;
            
        '); 
        $query->execute(['id'=>$id]);

    }
}