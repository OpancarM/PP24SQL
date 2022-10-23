<?php

class TrenerController extends AutorizacijaController
{

    private $viewDir = 
                'privatno' . DIRECTORY_SEPARATOR . 
                    'treneri' . DIRECTORY_SEPARATOR;

    private $trener;
    private $poruka;

    public function __construct()
    {
        parent::__construct();
        $this->trener = new stdClass();
        $this->trener->sifra=0;
        $this->trener->ime='';
        $this->trener->prezime='';
        $this->trener->oib='';
        $this->trener->email='';
        $this->trener->ples='';
    }


    public function index()
    {
        $treneri = Trener::read();
        $this->view->render($this->viewDir . 'index',[
           'treneri'=>$treneri
       ]);
    }   

    public function detalji($sifra=0)
    {
        if($sifra===0){
            $this->view->render($this->viewDir . 'detalji',[
                'trener'=>$this->trener,
                'poruka'=>'Unesite tražene podatke',
                'akcija'=>'Dodaj novi'
            ]);
        }else{
            $this->view->render($this->viewDir . 'detalji',[
                'trener'=>Trener::readOne($sifra),
                'poruka'=>'Promjenite podatke',
                'akcija'=>'Promjena'
            ]);
        }

    }

    public function akcija()
    {
        if($_POST['sifra']==0){
           
            if($this->kontrolaOIB($_POST['oib'])){
                $sifra = Trener::create($_POST);
            }else{
                $this->view->render($this->viewDir . 'detalji',[
                    'trener'=>(object)$_POST,
                    'poruka'=>'Neispravan OIB',
                    'akcija'=>'Dodaj novi'
                ]);
                return;
            }
            
        }else{
         
            Trener::update($_POST);
            $sifra=$_POST['sifra'];
        }

        header('location:' . App::config('url').'trener/index');
    }


    public function brisanje($sifra)
    {
        TRener::delete($sifra);
        header('location:' . App::config('url').'trener/index');
    }



    private function kontrolaOIB($oib) {

        if (strlen($oib) != 11 || !is_numeric($oib)) {
            return false;
        }
    
        $a = 10;
    
        for ($i = 0; $i < 10; $i++) {
    
            $a += (int)$oib[$i];
            $a %= 10;
    
            if ( $a == 0 ) { $a = 10; }
    
            $a *= 2;
            $a %= 11;
    
        }
    
        $kontrolni = 11 - $a;
    
        if ( $kontrolni == 10 ) { $kontrolni = 0; }
    
        return $kontrolni == intval(substr($oib, 10, 1), 10);
    }


    public function traziTrener($uvjet)
    {
        header('Content-type: application/json');
        echo json_encode(Trener::traziTrener($uvjet));
    }



    public function dodajTrener($ime,$prezime)
    {
        echo Trener::create([
            'ime'=>$ime,
            'prezime'=>$prezime,
            'oib'=>'',
            'email'=>''       
        ]);
    }

}