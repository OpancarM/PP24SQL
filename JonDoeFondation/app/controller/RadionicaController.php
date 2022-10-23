<?php

class RadionicaController extends AutorizacijaController
{

    private $viewDir = 
                'privatno' . DIRECTORY_SEPARATOR . 
                    'radionice' . DIRECTORY_SEPARATOR;
    private $poruka;
    private $entitet;

    public function index()
    {
       $this->view->render($this->viewDir . 'index',[
        'entiteti' => Radionica::read()
       ]);
    }   

    public function novi()
    {
        header('location:' . App::config('url').'radionica/novi/' . 
        Radionica::create([
            'naziv'=>'Nova radionica',
            'tecaj'=>Tecaj::read()[0]->sifra,
            'datumpocetka'=>null]
            )
        );
    }

    
    public function dodajNovi()
    {
        Radionica::create($_POST);
        header('location:' . App::config('url').'radionica/index');
       
    }



    public function odustani($sifra)
    {
        if(Radionica::odustajanje($sifra)){
            Radionica::delete($sifra);
        }
        header('location:' . App::config('url').'radionica/index');
       
    }


    public function promjena($sifra)
    {
        
        $this->entitet = Radionica::readOne($sifra);
        if($this->entitet->trener!=null){
            $p = Trener::readOne($this->entitet->trener);
            $labelaTrenera = $p->ime . ' ' . $p->prezime;
        }else{
            $labelaTrenera='Nije odabrano';        }
        $this->view->render($this->viewDir . 'promjena',[
            'poruka'=>'Promjenite podatke',
            'e'=>$this->entitet,
            'labelaTrenera' => $labelaTrenera,
            'tecajevi'=>Tecaj::read(),
            'css'=>'<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">',
            'javascript'=>'<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
            <script>let radionica=' . $this->entitet->sifra . ';</script>
            <script src="' . App::config('url') . 'public/js/detaljiRadionice.js"></script>'
        ]);
    }

    public function promjeni()
    {
        Radionica::update($_POST);
        header('location:' . App::config('url').'radionica/index');
    }


    public function brisanje($sifra)
    {
        Radionica::delete($sifra);
        header('location:' . App::config('url').'radionica/index');
    }

    public function dodajPlesaca($radionica,$plesac)
    {
        echo Radionica::dodajPlesaca([
            'radionica'=>$radionica,
            'plesac'=>$plesac,
        ]) ? 'OK' : 'Greška';
    }

    public function brisiPlesaca($radionica,$plesac)
    {
        echo Radionica::brisiPlesaca([
            'radionica'=>$radionica,
            'plesac'=>$plesac,
        ]) ? 'OK' : 'Greška';
    }
}