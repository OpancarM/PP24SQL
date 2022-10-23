<?php

class TecajController extends AutorizacijaController
{

    private $viewDir = 
                'privatno' . DIRECTORY_SEPARATOR . 
                    'tecajevi' . DIRECTORY_SEPARATOR;
    private $nf;
    private $poruka;
    private $tecaj;

    public function __construct()
    {
        parent::__construct();
        
        $this->tecaj = new stdClass();
        $this->tecaj->naziv='';
        $this->tecaj->trajanje='130';
        $this->tecaj->cijena='';
        $this->tecaj->certificiran=false;
    }

    public function index()
    {
        $tecajevi = Tecaj::read();
       
        

       $this->view->render($this->viewDir . 'index',[
           'tecajevi' => $tecajevi,
           'javascript'=>'<script type="text/javascript" src="https://code.jquery.com/jquery-1.10.1.min.js"></script> 
           <script src="' . App::config('url') . 'public/js/vendor/tablesort.js"></script>
           <script src="' . App::config('url') . 'public/js/indexTecaj.js"></script>'
       ]);
    }   

    public function novi()
    {
        $this->view->render($this->viewDir . 'novi',[
            'poruka'=>'',
            'tecaj'=>$this->tecaj
        ]);
    }

    public function promjena($sifra)
    {
        $this->tecaj = Tecaj::readOne($sifra);

        if($this->tecaj->cijena==0){
            $this->tecaj->cijena='';
        }else{
            $this->tecaj->cijena=$this->nf->format($this->tecaj->cijena);
        }

        $this->view->render($this->viewDir . 'promjena',[
            'poruka'=>'Promjenite podatke',
            'tecaj'=>$this->tecaj
        ]);
    }


    public function promjeni()
    {
        $this->pripremiPodatke();
        
        if($this->kontrolaNaziv()
        && $this->kontrolaCijena()){
            tecaj::update((array)$this->tecaj);
            header('location:' . App::config('url').'tecaj/index');
        }else{
            $this->view->render($this->viewDir.'promjena',[
                'poruka'=>$this->poruka,
                'tecaj'=>$this->tecaj
            ]);
        }
    }

    public function brisanje($sifra)
    {
        Tecaj::delete($sifra);
        header('location:' . App::config('url').'tecaj/index');
    }

    private function pripremiPodatke()
    {
        $this->tecaj=(object)$_POST;
        if($this->tecaj->certificiran=='1'){
            $this->tecaj->certificiran=true;
        }else{
            $this->tecaj->certificiran=false;
        }
    }

    private function kontrolaNaziv()
    {
        if(strlen($this->tecaj->naziv)===0){
            $this->poruka='Naziv obavezno';
            return false;
        }
        if(strlen($this->tecaj->naziv)>50){
            $this->poruka='Naziv ne smije biti duži od 50 znakova';
            return false;
        }

        return true;
    }

    private function kontrolaTrajanje()
    {
        if(strlen(trim($this->tecaj->trajanje))===0){
            $this->poruka='Trajanje obavezno';
            return false;
        }

        $broj = (int) trim($this->tecaj->trajanje);
        if($broj<=0){
            $this->poruka='Trajanje mora biti cijeli broj veći od 0, unijeli ste: ' 
            . $this->tecaj->trajanje;
            $this->tecaj->trajanje='';
            return false;
        }


        return true;
    }

    private function kontrolaCijena()
    {
        if(strlen(trim($this->tecaj->cijena))>0){

          
            $this->tecaj->cijena = str_replace('.','',$this->tecaj->cijena);
            $this->tecaj->cijena = (float)str_replace(',','.',$this->tecaj->cijena);
            if($this->tecaj->cijena<=0){
                $this->poruka='Ako unosite cijenu, mora biti decimalni broj veći od 0, unijeli ste: ' 
            . $this->tecaj->cijena;
            $this->tecaj->cijena='';
            return false;
            }
        }

        return true;
    }

   
}