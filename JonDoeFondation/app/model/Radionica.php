<?php

class Radionica
{


    public static function brojPlesacaNaRadionici()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
        select a.naziv as name, count(b.plesac) as y
        from radionica a left join grupa b 
        on a.sifra=b.radionica
        group by a.naziv
        order by 2 desc;
        
        
        '); 
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function dodajPlesaca($parametri)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
            insert into clan (radionica,plesac)
            values (:radionica,:plesac);
        
        '); 
        return $izraz->execute($parametri);
    }

    public static function brisiPolaznik($parametri)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
            delete from grupa where radionica=:radionica and plesac=:plesac;
        
        '); 
        return $izraz->execute($parametri);
    }

    public static function odustajanje($kljuc)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
            select count(*) from radionica 
            where sifra=:parametar
            and naziv=\'Nova grupa\'
            and trener is null
            and datumpocetka is null
            and tecaj=(select sifra from tecaj order by certificiran desc, naziv limit 1);
        
        '); 
        $izraz->execute(['parametar'=>$kljuc]);
        return $izraz->fetchColumn()==1 ? true : false;
    }

    public static function readOne($kljuc)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
            select * from radionica where sifra=:parametar;
        
        '); 
        $izraz->execute(['parametar'=>$kljuc]);
        $radionica= $izraz->fetch();
        $izraz = $veza->prepare('
        
            select b.sifra, c.ime, c.prezime, c.email
            from grupa a
            inner join plesac b on a.plesac =b.sifra 
            inner join osoba c on b.osoba =c.sifra 
            where a.radionica = :parametar;
        
        '); 
        $izraz->execute(['parametar'=>$radionica->sifra]);
        $radionica->plesac=$izraz->fetchAll();
        return $radionica;
    }
    
    public static function read()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
            select a.sifra, a.naziv, b.naziv as tecaj, 
            concat(d.ime, \' \', d.prezime) as trener,
            a.datumpocetka, count(e.plesac) as plesac
            from radionica a inner join tecaj b on 
            a.tecaj=b.sifra
            left join trener c on a.trener =c.sifra 
            left join osoba d on c.osoba =d.sifra
            left join grupa e on a.sifra=e.radionica 
            group by a.sifra, a.naziv, b.naziv, 
            concat(d.ime, \' \', d.prezime), a.datumpocetka;
        
        
        '); 
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function create($parametri)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
            insert into grupa (naziv,tecaj,trener,datumpocetka)
            values (:naziv,:tecaj,null,:datumpocetka);
        
        '); 
        $izraz->execute($parametri);
        return $veza->lastInsertId();
    }
    
    public static function update($parametri)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
            update radionica set 
                naziv=:naziv,
                tecaj=:tecaj,
                trener=:trener,
                datumpocetka=:datumpocetka
                where sifra=:sifra;
        
        '); 
        $izraz->execute($parametri);
        
    }

    public static function delete($sifra)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
            delete from radionica where sifra=:sifra;
        
        '); 
        $izraz->execute(['sifra'=>$sifra]);

    }
}