<?php

class CustomerController extends AuthorizationController
{
    private $viewDir = 
                'private' . DIRECTORY_SEPARATOR . 
                    'customers' . DIRECTORY_SEPARATOR;
    private $message;
    private $product;
      
    public function __construct()
    {
        parent::__construct();
        $this->customer = new stdClass();
        $this->customer->id=0;
        $this->customer->email='';
        $this->customer->userpassword='';
        $this->customer->firstname='';
        $this->customer->lastname='';
    }

    public function index()
    {
        $customer = Customer::read();

       $this->view->render($this->viewDir . 'index',[
           'customers' => $customer,
       ]);
    }   

    public function details($id=0)
    {
        if($id===0){
            $this->view->render($this->viewDir . 'details',[
                'customer'=>$this->customer,
                'message'=>'Add data',
                'action'=>'Add new'
            ]);
        }else{
            $this->view->render($this->viewDir . 'details',[
                'customer'=>Customer::readOne($id),
                'message'=>'Change data',
                'action'=>'Change'
            ]);
        }

    }

    public function action()
    {
        if($_POST['id']==0){
            Customer::create($_POST);
        }else{
            Customer::update($_POST);
        }
        header('location:' . App::config('url').'customer/index');

    }

    public function delete($id)
    {
        Customer::delete($id);
        header('location:' . App::config('url').'customer/index');
    }
}


