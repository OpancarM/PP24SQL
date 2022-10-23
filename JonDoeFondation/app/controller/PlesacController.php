<?php

class PlesacController extends AutorizacijaController
{

    private $viewDir = 
                'privatno' . DIRECTORY_SEPARATOR . 
                    'plesaci' . DIRECTORY_SEPARATOR;

    private $plesaci;
    private $poruka;

    public function __construct()
    {
        parent::__construct();
        $this->plesac = new stdClass();
        $this->plesac->sifra=0;
        $this->plesac->ime='';
        $this->plesac->prezime='';
        $this->plesac->oib='';
        $this->plesac->email='';
        $this->plesac->ples='';
    }


    public function index()
    {

        if(!isset($_GET['stranica'])){
            $stranica=1;
        }else{
            $stranica=(int)$_GET['stranica'];
        }
        if($stranica==0){
            $stranica=1;
        }

        if(!isset($_GET['uvjet'])){
            $uvjet='';
        }else{
            $uvjet=$_GET['uvjet'];
        }

        $up = Plesac::ukupnoPlesaca($uvjet);
        $ukupnoStranica = ceil($up / App::config('rps'));
        
        if($stranica>$ukupnoStranica){
            $stranica = $ukupnoStranica;
        }

       $this->view->render($this->viewDir . 'index',[

            'plesaci'=>Plesac::read($stranica, $uvjet),
            'uvjet'=>$uvjet,
            'stranica' => $stranica,
            'ukupnoStranica'=>$ukupnoStranica,
            'css'=>'<link rel="stylesheet" href="' . App::config('url') . 'public/css/cropper.css">',
            'javascript'=>'<script src="' . App::config('url') . 'public/js/vendor/cropper.js"></script>
            <script src="' . App::config('url') . 'public/js/indexPolaznik.js"></script>'
       ]);
    }   

    public function detalji($sifra=0)
    {
        if($sifra===0){
            $this->view->render($this->viewDir . 'detalji',[
                'plesac'=>$this->plesac,
                'poruka'=>'Unesite tražene podatke',
                'akcija'=>'Dodaj novi'
            ]);
        }else{
            $this->view->render($this->viewDir . 'detalji',[
                'plesac'=>Plesac::readOne($sifra),
                'poruka'=>'Promjenite podatke',
                'akcija'=>'Promjena'
            ]);
        }

    }

    public function akcija()
    {
        if($_POST['sifra']==0){
           
            if($this->kontrolaOIB($_POST['oib'])){
                $sifra = Plesac::create($_POST);
            }else{
                $this->view->render($this->viewDir . 'detalji',[
                    'Plesac'=>(object)$_POST,
                    'poruka'=>'Neispravan OIB',
                    'akcija'=>'Dodaj novi'
                ]);
                return;
            }
            
        }else{
            
            Plesac::update($_POST);
            $sifra=$_POST['sifra'];
        }
        header('location:' . App::config('url').'plesac/index');
    }


    public function brisanje($sifra)
    {
        Plesac::delete($sifra);
        header('location:' . App::config('url').'plesac/index');
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

    public function traziPlesac($uvjet,$radionica)
    {
        header('Content-type: application/json');
        echo json_encode($this->postaviSlike(Plesac::traziPlesac($uvjet,$radionica)));
    }    
}