<?php

class PublicProductController extends AuthorizationController
{
    private $viewDir = 
                'private' . DIRECTORY_SEPARATOR . 
                    'publicproducts' . DIRECTORY_SEPARATOR;
    
    private $publicproduct;
      
    public function __construct()
    {
        parent::__construct();
        $this->publicproduct = new stdClass();
        $this->publicproduct->id=0;
        $this->publicproduct->iname='';
        $this->publicproduct->price='';
        $this->publicproduct->idescription='';
    }

    public function index()
    {

        $publicproduct = Product::read();
        foreach($publicproduct as $p){
            if(file_exists(BP . 'public' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR
            . 'products' . DIRECTORY_SEPARATOR . $p->id . '.png' )){
                $p->picture= App::config('url') . 'public/img/products/' . $p->id . '.png';
            }else{
                $p->picture= App::config('url') . 'public/img/products/unkown.png';
            }
        }

       $this->view->render($this->viewDir . 'index',[
           'publicproducts' => $publicproduct
       ]);
    } 
}