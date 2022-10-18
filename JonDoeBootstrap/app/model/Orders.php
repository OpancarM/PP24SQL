<?php

class Orders
{


    public static function getOrder($id)
    {
        $connection = DB::getInstanca();
        $query = $connection->prepare('
        
            select id, customer, dateadded
            from orders 
            where finished = 0 and customer=:customerId
            
        ');

        $query->execute([

            'customerId' => $id

        ]);

        return $query->fetch();
    }

    public static function create($id)
    {
        $connection = DB::getInstanca();
        $query = $connection->prepare('

            insert into orders (customer,dateadded, finished) values
            (:customerId, now(), 0)
            
        ');

        $query->execute([

            'customerId' => $id

        ]);

    }

    public static function addToCart($product, $ordersId, $quantity)
    {
        $connection = DB::getInstanca();
        $query = $connection->prepare('

            select a.quantity
            from cart as a
            inner join orders as b on a.orders = b.id
            where a.product = :product and b.id = :ordersId
            
        ');

        $query->execute([

            'product' => $product,
            'ordersId' => $ordersId

        ]);

        $existsInCart = $query->fetchColumn();

        if($existsInCart == 0){
            $query = $connection->prepare('

            insert into cart (orders, product, price, quantity, dateadded) values
            (:ordersId, :product, (select price from product where id = :product), 1, now())
            
            ');

            return $query->execute([

                'product' => $product,
                'ordersId' => $ordersId

            ]);

        }else{
            $query = $connection->prepare('

            update cart a
            inner join orders as b on a.orders=b.id
            set a.quantity = a.quantity+1
            where product = :product and b.id= :ordersId
            
            ');

            return $query->execute([

                'product' => $product,
                'ordersId' => $ordersId

            ]);
        }
    }

    public static function deleteFromCart($product, $ordersId)
    {
        $connection = DB::getInstanca();
        $query = $connection->prepare('

            delete from cart 
            where product = :product and orders = :ordersId
            
        ');

        return $query->execute([

            'product' => $product,
            'ordersId' => $ordersId

        ]);
    }

    public static function getOrderCart($id)
    {
        $connection = DB::getInstanca();
        $query = $connection->prepare('

            select a.id as ordersId,c.id as id, c.item_name, c.item_description, b.price, b.quantity
            from orders a
            inner join cart b on a.id=b.orders
            inner join product c on b.product=c.id
            where a.finished = 0 and a.customer = :customerId
            
        ');
        $query->execute([

            'customerId' => $id

        ]);

        return $query->fetchAll();
    }

    public static function sumTotal($id)
    {
        $connection = DB::getInstanca();
        $query = $connection->prepare('

            select sum(b.item*b.quantity) as number
            from orders a
            inner join cart b on a.id=b.orders
            where a.finished = 0 and a.customer = :customerId
            
        ');
        $query->execute([

            'customerId' => $id

        ]);

        return $query->fetchColumn();
    }

    public static function finishOrder($customerId)
    {
        $connection = DB::getInstanca();
        $query = $connection->prepare('

        update orders
        set finished = 1
        where finished = 0 and customer = :customerId
            
        ');

        $query->execute([

            'customerId' => (int)$customerId

        ]);
    }

    
}