<?php

class CustomerController extends AuthorizationController
{
    private $viewDir =  'private' . DIRECTORY_SEPARATOR . 
                        'customers' . DIRECTORY_SEPARATOR;

    private $message;
    private $customer;

    public function __construct()
    {
        parent::__construct();
        $this->customer = new stdClass();
        $this->customer->email='';
        $this->customer->userpassword='';
        $this->customer->firstname='';
        $this->customer->lastname='';
    }

    public function index()
    {
        $customers = Customer::read();

        $this->view->render($this->viewDir . 'index', [
            'customers' => $customers
        ]);
    }

    public function newcustomer()
    {
        $this->view->render($this->viewDir . 'newcustomer',[
            'messsage'=>'',
            'customer'=>$this->customer
        ]);
    }

    public function change($id)
    {
        $this->customer = Customer::readOne($id);

        $this->view->render($this->viewDir . 'change',[
            'messsage'=>'Change the data',
            'customer'=>$this->customer
        ]);
    }

    public function addNew()
    {
        $this->prepareData();

        if($this->controlEmail()
        && $this->controlUserpassword()
        && $this->controlFirstname()
        && $this->controlLastname()){
            Customer::create((array)$this->customer);
            $this->index();
        }else{
            $this->view->render($this->viewDir.'newcustomer',[
                'message'=>$this->message,
                'customer'=>$this->customer
            ]);
        }
    }

    public function changing()
    {
        $this->prepareData();

        if($this->controlEmail()
        && $this->controlUserpassword()
        && $this->controlFirstname()
        && $this->controlLastname()){
            Customer::create((array)$this->customer);
            $this->index();
        }else{
            $this->view->render($this->viewDir.'change',[
                'message'=>$this->message,
                'customer'=>$this->customer
            ]);
        }
    }

    public function delete($id)
    {
        Customer::delete($id);
        header('location:' . App::config('url').'customers/index');
    }

    private function prepareData()
    {
        $this->customer=(object)$_POST;
    }

    private function controlEmail()
    {
        if(strlen($this->customer->email)===0){
            $this->message='Email Required';
            return false;
        }
        if(strlen($this->customer->email)>50){
            $this->message='Email cannot be longer than 50 characters';
            return false;
        }

        return true;
    }

    private function controlUserpassword()
    {
        if(strlen($this->customer->userpassword)===0){
            $this->message='Password Required';
            return false;
        }
        if(strlen($this->customer->userpassword)>50){
            $this->message='Password cannot be longer than 50 characters';
            return false;
        }

        return true;
    }

    private function controlFirstname()
    {
        if(strlen($this->customer->firstname)===0){
            $this->message='Firts name Required';
            return false;
        }
        if(strlen($this->customer->firstname)>50){
            $this->message='First name cannot be longer than 50 characters';
            return false;
        }

        return true;
    }

    private function controlLastname()
    {
        if(strlen($this->customer->lastname)===0){
            $this->message='Last name Required';
            return false;
        }
        if(strlen($this->customer->lastname)>50){
            $this->message='Last name cannot be longer than 50 characters';
            return false;
        }

        return true;
    }
}


