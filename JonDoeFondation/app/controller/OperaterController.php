<?php

class OperaterController extends AdminController
{

    private $viewDir = 
                'privatno' . DIRECTORY_SEPARATOR . 
                    'operateri' . DIRECTORY_SEPARATOR;
                    
    private $poruka;
    private $e;

    public function __construct()
    {
        parent::__construct();
       
    }

    public function index()
    {
       
       $this->view->render($this->viewDir . 'index');
    }  

   
}