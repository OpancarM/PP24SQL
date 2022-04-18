<?php

class Product
{
    public static function readOne($key)
    {
        $connection = DB::getInstance();
        $query = $connection->prepare('
        
            select * from product where id=:parameter;
        
        '); 
        $query->execute(['parameter'=>$key]);
        return $query->fetchAll();
    }

    public static function read()
    {
        $connection = DB::getInstance();
        $query = $connection->prepare('
        
        select a.id,a.item_name,a.item_price,a.item_description,a.item_image,
        count(b.id) as cart
        from product a left join cart b
        on a.id = b.product 
        group by a.id,a.item_name,a.item_price,a.item_description,a.item_image;
        
        '); 
        $query->execute();
        return $query->fetchAll();
    }

    public static function create($parameter)
    {
        $connection = DB::getInstance();
        $query = $connection->prepare('
        
            insert into product (item_name,item_price,item_description,item_image)
            values (:item_name,:item_price,:item_description,:item_image);
        
        '); 
        $query->execute($parameter);
        
    }
    

    public static function update($parameter)
    {
        $connection = DB::getInstance();
        $query = $connection->prepare('
        
            update product set 
                item_name=:item_name,
                item_price=:item_price,
                item_description=:item_description,
                item_image=item_image
                where id=:id;
        
        '); 
        $query->execute($parameter);
        
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
