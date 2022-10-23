<?php

class Plesac
{

    public static function ukupnoPlesaca($uvjet)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
            select count(a.sifra)
            from plesac a 
            inner join osoba b on a.osoba = b.sifra 
            where concat(b.ime, \' \', b.prezime, \' \', ifnull(b.oib,\'\')) like :uvjet
      
        
        '); 
        $uvjet = '%' . $uvjet . '%';
        $izraz->bindParam('uvjet',$uvjet);
        $izraz->execute();
        return $izraz->fetchColumn();
    }


    public static function readOne($kljuc)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
            select a.sifra, b.ime, b.prezime, b.email, b.oib
            from plesac a inner join osoba b on
            a.osoba = b.sifra 
            where a.sifra=:parametar
        
        '); 
        $izraz->execute(['parametar'=>$kljuc]);
        return $izraz->fetch();
    }

    public static function traziPlesaca($uvjet,$radionica)
    {


        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
            select a.sifra, b.ime, b.prezime, b.email, b.oib,a.ples
            from plesac a 
            inner join osoba b on a.osoba = b.sifra 
            left join grupa c on a.sifra =c.plesac 
            where concat(b.ime, \' \', b.prezime, \' \', ifnull(b.oib,\'\')) like :uvjet
            and a.sifra not in (select plesac from grupa where radionica=:radionica)
            order by 3, 2 limit 20
        
        '); 
        $uvjet = '%' . $uvjet . '%';
        $izraz->bindParam('uvjet',$uvjet);
        $izraz->bindParam('radionica',$radionica);
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function read($stranica, $uvjet)
    {

        $rps = App::config('rps');
        $od = $stranica * $rps - $rps;

        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
            select a.sifra, b.ime, b.prezime, b.email, b.oib ,a.ples,
            count(c.radionica) as radionica
            from plesac a 
            inner join osoba b on a.osoba = b.sifra 
            left join grupa c on a.sifra =c.plesac 
            where concat(b.ime, \' \', b.prezime, \' \', ifnull(b.oib,\'\')) like :uvjet
            group by 
            a.sifra, b.ime, b.prezime, b.email, b.oib,a.ples
            order by 3, 2
            limit :od, :rps
        
        '); 
        $uvjet = '%' . $uvjet . '%';
        $izraz->bindValue('od',$od,PDO::PARAM_INT);
        $izraz->bindValue('rps',$rps,PDO::PARAM_INT);
        $izraz->bindParam('uvjet',$uvjet);
        $izraz->execute();
        return $izraz->fetchAll();
    }


    public static function create($parametri)
    {
        $veza = DB::getInstanca();
        $veza->beginTransaction();
        $izraz = $veza->prepare('
        
        insert into osoba (ime,prezime,oib,email) values 
        (:ime,:prezime,:oib,:email)
        
        '); 
        $izraz->execute([
            'ime'=>$parametri['ime'],
            'prezime'=>$parametri['prezime'],
            'oib'=>$parametri['oib'],
            'email'=>$parametri['email']
        ]);


        $zadnjaSifra = $veza->lastInsertId();

        $izraz = $veza->prepare('
        
        insert into plesac (osoba,ples) values 
        (:osoba,:ples)
        
        '); 
        $izraz->execute([
            'osoba'=>$zadnjaSifra,
            'ples'=>$parametri['ples']
        ]);

        $sifraPlesac = $veza->lastInsertId();
        $veza->commit();   
        return $sifraPlesac;         
    }
    

    //U - Update
    public static function update($parametri)
    {
        $veza = DB::getInstanca();
        $veza->beginTransaction();
        $izraz = $veza->prepare('
        
        select osoba from plesac where sifra=:sifra
        
        '); 
        $izraz->execute([
            'sifra'=>$parametri['sifra']
        ]);

        $sifraOsoba = $izraz->fetchColumn();


        $izraz = $veza->prepare('
        
            update osoba set
            ime=:ime,
            prezime=:prezime,
            oib=:oib,
            email=:email
            where sifra=:sifra
        
        '); 
        $izraz->execute([
            'sifra'=>$sifraOsoba,
            'ime'=>$parametri['ime'],
            'prezime'=>$parametri['prezime'],
            'oib'=>$parametri['oib'],
            'email'=>$parametri['email']
        ]);

        $izraz = $veza->prepare('
        
            update plesac set
            ples=:ples
            where sifra=:sifra
        
        '); 
        $izraz->execute([
            'sifra'=>$parametri['sifra'],
            'ples'=>$parametri['ples']
        ]);


        $veza->commit();
    }

    public static function delete($sifra)
    {
        $veza = DB::getInstanca();
        $veza->beginTransaction();
        $izraz = $veza->prepare('
        
        select osoba from plesac where sifra=:sifra
        
        '); 
        $izraz->execute([
            'sifra'=>$sifra
        ]);

        $sifraOsoba = $izraz->fetchColumn();

        $izraz = $veza->prepare('
        
        delete from plesac where sifra=:sifra
        
        '); 
        $izraz->execute([
            'sifra'=>$sifra
        ]);

        $izraz = $veza->prepare('
        
        delete from osoba where sifra=:sifra
        
        '); 
        $izraz->execute([
            'sifra'=>$sifraOsoba
        ]);


        $veza->commit();
    }
}