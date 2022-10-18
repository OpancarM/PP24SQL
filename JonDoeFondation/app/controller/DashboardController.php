<?php

class DashboardController extends AuthorizationController
{
    private $viewDir = 'private' . DIRECTORY_SEPARATOR;
    

    private $customer;
    private $message;

    public function __construct()
    {
        parent::__construct();
        
        $this->customer = new stdClass();
        $this->customer->id = null;
        $this->customer->firstname = '';
        $this->customer->lastname = '';
        $this->customer->email = '';
        $this->customer->phonenumber = '';
        $this->customer->street = '';
        $this->customer->city = '';
        $this->customer->postalnumber = '';

    }

    // Dashboard profile
    public function index($change=0)
    {
        $this->customer = Customer::readOne($_SESSION['authorized']->id);

        $this->view->render($this->viewDir . 'dashboard',[
            'user'=>$_SESSION['authorized'],
            'customer'=>$this->customer
            
            
        ]);
    }

    

    
}