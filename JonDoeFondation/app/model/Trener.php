<?php

class Trener
{

    public static function traziTrenera($uvjet)
    {


        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
                select a.sifra, b.ime, b.prezime
                from trener a 
                inner join osoba b on a.osoba = b.sifra 
                where concat(b.ime, \' \', b.prezime) like :uvjet
                order by 3, 2 
        
        '); 
        $uvjet = '%' . $uvjet . '%';
        $izraz->bindParam('uvjet',$uvjet);
        $izraz->execute();
        return $izraz->fetchAll();
    }


    public static function readOne($kljuc)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
            select a.sifra, b.ime, b.prezime, b.email, b.oib, a.ples 
            from trener a inner join osoba b on
            a.osoba = b.sifra 
            where a.sifra=:parametar
        
        '); 
        $izraz->execute(['parametar'=>$kljuc]);
        return $izraz->fetch();
    }

    public static function read()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
            select a.sifra, b.ime, b.prezime, b.email, b.oib, a.ples, 
            count(c.sifra) as radionica
            from trener a 
            inner join osoba b on a.osoba = b.sifra 
            left join radionica c on a.sifra =c.trener
            group by 
            a.sifra, b.ime, b.prezime, b.email, b.oib, a.ples
            order by 3, 2
        
        '); 
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
        
        insert into trener (osoba,ples) values 
        (:osoba,:ples)
        
        '); 
        $izraz->execute([
            'osoba'=>$zadnjaSifra,
            'ples'=>$parametri['ples']
        ]);
        $sifraTrener = $veza->lastInsertId();
        $veza->commit();   
        return $sifraTrener;     
    }
    
    public static function update($parametri)
    {
        $veza = DB::getInstanca();
        $veza->beginTransaction();
        $izraz = $veza->prepare('
        
        select osoba from trener where sifra=:sifra
        
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
        
            update trener set
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
        
        select osoba from trener where sifra=:sifra
        
        '); 
        $izraz->execute([
            'sifra'=>$sifra
        ]);

        $sifraOsoba = $izraz->fetchColumn();

        $izraz = $veza->prepare('
        
        delete from trener where sifra=:sifra
        
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