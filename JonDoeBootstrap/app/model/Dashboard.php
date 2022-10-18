<?php

class Dashboard
{

    public static function getOrders($id)
    {
        $connection = DB::getInstance();
        $query = $connection->prepare('

            select *
            from orders
            where customer=:customerId and finished=1
            order by dateadded desc
            
        ');
        $query->execute([
            'customerId' => $id
        ]);

        return $query->fetchall();
    }

    public static function getOrderDetails($id)
    {
        $connection = DB::getInstance();
        $query = $connection->prepare('

            select b.id, c.item_name, c.item_description,c.id as productId, c.item_price as productPrice, a.price, a.quantity
            from cart a
            inner join orders b on a.orders=b.id
            inner join product c on a.product=c.id
            where b.customer = :id and b.finished = 1
            
        ');
        $query->execute([
            'id' => $id
        ]);

        return $query->fetchall();
    }
}