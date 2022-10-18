<?php 

class Product
{
   
    
    public static function readOne($key)
    {
        $connection = DB::getInstance();
        $query = $connection->prepare('
        
            select * from product where id=:param;
        
        '); 
        $query->execute(['param'=>$key]);
        return $query->fetchAll();
    }

    public static function read()
    {
        $connection = DB::getInstance();
        $query = $connection->prepare('
        
            select a.id,a.iname,a.price,a.idescription,
            count(b.id) as cart
            from product a left join cart b
            on a.id = b.product 
            group by a.id,a.iname,a.price,a.idescription;  
        '); 

        $query->execute();
        return $query->fetchAll();
    }

    public static function create($param)
    {
        $connection = DB::getInstance();
        $connection->beginTransaction();
        $query = $connection->prepare('
        
            insert into product (iname,price,idescription)
            values (:iname,:price,:idescription);
        
        '); 

        $query->execute($param);
        
        $idProduct = $connection->lastInsertId();
        $connection->commit();   
        return $idProduct; 
        
    }
    

    public static function update($param)
    {
        $connection = DB::getInstance();
        $query = $connection->prepare('
        
            update product set 
                iname=:iname,
                price=:price,
                idescription=:idescription
                where id=:id;
        
        '); 
        
        $query->execute($param);
        $connection->commit();
        
    }
 
    public static function delete($id)
    {
        $connection = DB::getInstance();
        $query = $connection->prepare('
        
            delete from product where id=:id;
        
        '); 
        $query->execute(['id'=>$id]);

    }
    
}