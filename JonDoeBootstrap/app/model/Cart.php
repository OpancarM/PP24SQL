<?php

class Cart
{
    public static function amountProduct()
    {
        $connection = DB::getInstanca();
        $query = $connection->prepare('
        
            select count(a.id) from product;
            
        '); 

        $query->execute();
        return $query->fetch();
    }


    public static function readOne($key)
    {
        $connection = DB::getInstance();
        $query = $connection->prepare('
        
            select b.id, c.item_name, c.item_price
            from product a
            inner join customer b on a.customer =b.id
            where a.cart = :param;
        
        '); 
        $izraz->execute(['param'=>$key]);
        $cart= $query->fetchAll();
        return $cart;
    }


     public static function read()
     {
         $connection = DB::getInstance();
         $query = $connection->prepare('

            select b.id, c.item_name, c.item_price
            from product a
            inner join customer b on a.customer =b.id
            where a.cart = :param;
             
             
         ');
         $query->execute();
         return $query->fetch();
     }
 
     public static function create($param)
     {
         $connection = DB::getInstance();
         $query = $connection->prepare('

            insert into cart (product) values
            (:product, now(), null);
             
         ');
         $query->execute($parameter);
         return $query->lastInsertId();
 
     }
 
     public static function addtocart($param)
     {
         $connection = DB::getInstance();
 
         $query = $connection->prepare('

            insert into cart (product)
            values (:product);
             
         ');

        return $izraz->execute($param);
 
         $existsInCart = $query->fetchColumn();
 
         if($existsInCart == 0){
             $query = $connection->prepare('

             insert into cart (product, item_price, quantity) values
             (:product, :item_price (select price from product where id = :product), 1, now())
             
             ');
             return $query->execute([

                'product' => $product,
                'cartId' => $cartId

             ]);

         }else{
             $query = $connection->prepare('
             
             update cart a
             set a.quantity = a.quantity+1
             where product = :product;
             
             ');

             return $query->execute([

                'product' => $product,
                'cartId' => $cartId
                
             ]);
         }
     }
 
     public static function removefromcart()
     {
         $connection = DB::getInstance();
         $query = $connection->prepare('

            delete from cart 
            where product = :product;
             
         ');

         return $query->execute([

            'product' => $product,
            'cartId' => $cartId

         ]);
 
         
     }
   
     public static function sumTotal($id)
     {
         $connection = DB::getInstance();
         $query = $connection->prepare('

             select sum(b.price*b.quantity) as number
             from cart a
             inner join cart b on a.id=b.cart
             
         ');
         $query->execute([

             'customerId' => $id

         ]);
 
         return $query->fetchColumn();
     }

     public static function brojPolaznikaNaGrupi()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
        select a.naziv as name, count(b.polaznik) as y
        from grupa a left join clan b 
        on a.sifra=b.grupa
        group by a.naziv
        order by 2 desc;
        
        
        '); 
        $izraz->execute();
        return $izraz->fetchAll();
    }
 
}