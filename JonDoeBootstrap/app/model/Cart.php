<?php

class Cart{


    public static function readOne($ey)
    {
        $connection = DB::getInstance();
        $query = $connection->prepare('
        
            select * from cart where id=:parameter;
        
        '); 
        $izraz->execute(['parameter'=>$key]);
        $cart= $query->fetchAll();
        return $cart;
    }


     public static function read()
     {
         $connection = DB::getInstance();
         $query = $connection->prepare('

            select a.id, a.item_name, b.item_name as product, 
            concat(d.firstname, \' \', d.lastname) as customer
            from cart a inner join product b on 
            a.product=b.id
            left join customer c on a.customer =c.id 
            group by a.id, a.item_name, b.item_name, 
            concat(d.firstname, \' \', d.lastname);
             
             
         ');
         $query->execute();
         return $query->fetch();
     }
 
     public static function create($parameter)
     {
         $connection = DB::getInstance();
         $query = $connection->prepare('

            insert into cart (product) values
            (:product, now(), null);
             
         ');
         $query->execute($parameter);
         return $query->lastInsertId();
 
     }
 
     public static function addtocart($parameter)
     {
         $connection = DB::getInstance();
 
         $query = $connection->prepare('

            insert into cart (product)
            values (:product);
             
         ');

        return $izraz->execute($parameter);
 
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
 
}