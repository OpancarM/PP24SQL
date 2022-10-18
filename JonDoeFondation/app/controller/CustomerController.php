<?php

class CustomerController extends AuthorizationController
{
    private $viewDir = 
                'private' . DIRECTORY_SEPARATOR . 
                    'customers' . DIRECTORY_SEPARATOR;
    private $customers;
      
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

    public function index()
    {

        $customers= Customer::read();
        
        $this->view->render($this->viewDir . 'index',[
           'customers' => $customers

        ]);
    }   

    public function delete($id)
    {
        Product::delete($id);
        header('location:' . App::config('url').'customer/index');
    }
}


