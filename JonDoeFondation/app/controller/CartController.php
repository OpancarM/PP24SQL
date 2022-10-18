<?php

class CartController extends AuthorizationController
{
    private $viewDir = 
                'private' . DIRECTORY_SEPARATOR . 
                    'cart' . DIRECTORY_SEPARATOR;

    public function __construct()
    {
        parent::__construct();
        $this->cart = new stdClass();
        $this->cart->id=0;
        $this->cart->iname='';
        $this->cart->price='';
    }

    public function index()
    {
    

        $this->view->render($this->viewDir . 'index', [
            'cart' => Cart::read()
        ]);
    }

    public function addtocart($product)
    {
       if($_SERVER["REQUEST_METHOD"]=="POST")
       {
        if(isset($_POST['addtocart']))
        {
            
        }
       }
         
        header('location:' . App::config('url').'product/index');
  
    }
    
}