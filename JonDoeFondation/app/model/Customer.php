<?php 

class Customer
{
    
    public static function readOne($key)
    {
        $connection = DB::getInstance();
        $query = $connection->prepare('
        
            select * from customer where id=:param;
        
        '); 
        $query->execute(['param'=>$key]);
        return $query->fetchAll();
    }

    public static function read()
    {
        $connection = DB::getInstance();
        $query = $connection->prepare('
        
            select * from customer
            
            
        '); 

        $query->execute();
        return $query->fetchAll();
    }

    public static function create($param)
    {
        $connection = DB::getInstance();
        $connection->beginTransaction();
        $query = $connection->prepare('
        
            insert into customer (email,userpassword,firstname,lastname,phonenumber, street, city, postalnumber)
            values (:email, :userpassword, :firstname, :lastname , :phonenumber, :street, :city, :postalnumber)
        
        '); 

        $query->execute($param);
        
        $idCustomer = $connection->lastInsertId();
        $connection->commit();   
        return $idCustomer; 
        
    }
    

    public static function update($param)
    {
        $connection = DB::getInstance();
        $query = $connection->prepare('
        
            update customer set 
            email=:email,
            userpassword=:userpassword,
            firstname=:firstname,
            lastname=:lastname,
            phonenumber=:phonenumber,
            street=:street,
            city=:city,
            postalnumber=:postalnumber
            where id=:id;
        
        '); 
        
        $query->execute($param);
        $connection->commit();
        
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