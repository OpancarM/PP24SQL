<?php

class Cart
{

    public static function totalProducts()
    {
        $connection = DB::getInstanca();
        $query = $connection->prepare('

            select
            count(b.product) as product
            from cart a 
            inner join product b on a.product=b.id;

        ');

        $query->execute();
        return $query->fetchAll();
    }

    public static function addtocart($param)
    {
        $connection = DB::getInstance();

        $query = $connection->prepare('

        insert into cart (customer,product)
        values (:customer,:product);
            
        ');
        $query->execute($param);
    }

    public static function removeFromCart($param)
    {
        $connection = DB::getInstanca();
        $query = $connection->prepare('

            delete from cart where id = :id;

        ');

        return $query->execute($param);
    }

    public static function readOne($key)
    {
        $connection = DB::getInstanca();
        $query = $connection->prepare('
        
            select * from cart where id=:param;
        
        '); 
        $query->execute(['param'=>$key]);
        $cart= $query->fetch();
        $query = $connection->prepare('
        
            select a.id,a.price,a.quantity, b.id,b.firstname,b.lastname,c.iname, c.price
            from cart a
            inner join customer b on a.customer = b.id
            inner join product c on a.product = c.id
            group by a.id,c.iname;
          
        
        '); 
        $query->execute(['param'=>$cart->id]);
        $cart->product=$query->fetchAll();
        return $cart;
    }

    public static function read()
    {
        $connection = DB::getInstance();
        $query = $connection->prepare('

            select a.id,a.price,a.quantity, b.id,b.firstname,b.lastname,c.iname, c.price
            from cart a
            inner join customer b on a.customer = b.id
            inner join product c on a.product = c.id
            group by a.id,c.iname;
          
            
            
        '); 
        $query->execute();
        return $query->fetchAll();
    }

    //U - Update
    public static function update($param)
    {
        $connection = DB::getInstanca();
        $query = $connection->prepare('
        
            update cart set 
                product=:product,
                customer=:customer,
                dateadded=:dateadded
                where id=:id;
        
        '); 
        $query->execute($param);
        
    }

    public static function totalPrice()
    {
        $connection = DB::getInstanca();
        $query = $connection->prepare('

            select
            sum(b.price * a.quantity) as price
            from cart a 
            inner join product b on a.product=b.id;

        ');

        $query->execute();
        return $query->fetchColumn();
    }    
}