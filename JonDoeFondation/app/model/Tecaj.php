<?php

class Tecaj
{


    public static function readOne($kljuc)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
            select * from tecaj where sifra=:parametar;
        
        '); 
        $izraz->execute(['parametar'=>$kljuc]);
        return $izraz->fetch();
    }

    public static function read()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
            select a.sifra, a.naziv, a.trajanje, a.cijena , a.certificiran,
            count(b.sifra) as radionica
            from tecaj a left join radionica b
            on a.sifra =b.tecaj 
            group by a.sifra, a.naziv, a.trajanje, a.cijena , a.certificiran
            order by 5 desc, 2;
        
        '); 
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function create($parametri)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
            insert into tecaj (naziv,trajanje,cijena,certificiran)
            values (:naziv,:trajanje,:cijena,:certificiran);
        
        '); 
        $izraz->execute($parametri);
        
    }
    

    //U - Update
    public static function update($parametri)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
            update tecaj set 
                naziv=:naziv,
                trajanje=:trajanje,
                cijena=:cijena,
                certificiran=:certificiran
                where sifra=:sifra;
        
        '); 
        $izraz->execute($parametri);
        
    }

    //D - Delete
    public static function delete($sifra)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
            delete from tecaj where sifra=:sifra;
        
        '); 
        $izraz->execute(['sifra'=>$sifra]);

    }
}