<?php

class Admin
{
    public static function totalCustomers()
    {
        $connection = DB::getInstance();
        $query = $connection->prepare('
        
                select count(*)
                from customer
        
        ');

        $query->execute();
        return  $query->fetchColumn();
    }

    public static function last2weeks()
    {
        $connection = DB::getInstance();
        $query = $connection->prepare('
        
                select count(*)
                from customer
                where datecreated > (select DATE_SUB(curdate(), INTERVAL 2 WEEK))
        
        ');

        $query->execute();
        return  $query->fetchColumn();
    }

    public static function activeCustomers()
    {
        $connection = DB::getInstance();
        $query = $connection->prepare('
        
                select count(*)
                from customer
                where date(lastOnline) > DATE(DATE_SUB(curdate(), INTERVAL 1 day))
        
        ');

        $query->execute();
        return  $query->fetchColumn();
    }

    public static function activeOrders()
    {
        $connection = DB::getInstance();
        $query = $connection->prepare('
        
            select count(id)
            from orders
            where finished = false
            
        ');

        $query->execute();
        return  $query->fetchColumn();
    }

    public static function closedOrders()
    {
        $connection = DB::getInstance();
        $query = $connection->prepare('
        
            select count(id)
            from orders
            where finished = true
            
        ');

        $query->execute();
        return  $query->fetchColumn();
    }

    public static function sumFinishedTotal()
    {
        $connection = DB::getInstance();
        $query = $connection->prepare('
        
            select sum(b.price*b.quantity) as number
            from orders a
            inner join cart b on a.id=b.orders
            where a.finished = 1
            
        ');

        $query->execute();
        return  $query->fetchColumn();
    }

    public static function sumActiveTotal()
    {
        $connection = DB::getInstance();
        $query = $connection->prepare('
        
            select sum(b.price*b.quantity) as number
            from orders a
            inner join cart b on a.id=b.orders
            where a.finished = 0
            
        ');

        $query->execute();
        return  $query->fetchColumn();
    }

    public static function totalProducts()
    {
        $connection = DB::getInstance();
        $query = $connection->prepare('
        
            select count(id)
            from product
            
        ');

        $query->execute();
        return  $query->fetchColumn();
    }

    public static function activeProducts()
    {
        $connection = DB::getInstance();
        $query = $connection->prepare('
        
        select count(a.id)
        from product a
        inner join cart b on a.id=b.product
        inner join orders c on b.orders=c.id
        where c.finished = false
            
        ');

        $query->execute();
        return  $query->fetchColumn();
    }


    public static function byCity()
    {
        $connection = DB::getInstance();
        $query = $connection->prepare('
        
        select a.city, count(b.id) as quantity
        from customer a
        left join orders b on a.id=b.customer
		group by a.city
        order by quantity desc

        ');

        $query->execute();
        return $query->fetchAll();
    }

    public static function mostSold()
    {
        $connection = DB::getInstance();
        $query = $connection->prepare('
        
        select a.name, count(b.product) as quantity
        from product a
        left join cart b on b.product=a.id
		group by a.name
        order by quantity  desc
        limit 10

        ');

        $query->execute();
        return $query->fetchAll();
    }

    public static function lessSold()
    {
        $connection = DB::getInstance();
        $query = $connection->prepare('
        
        select a.name, count(b.product) as quantity
        from product a
        left join cart b on b.product=a.id
		group by a.name
        order by quantity  asc
        limit 10

        ');

        $query->execute();
        return $query->fetchAll();
    }
}