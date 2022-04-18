<?php

class ProductController extends AuthorizationController
{
    private $viewDir = 
                'private' . DIRECTORY_SEPARATOR . 
                    'products' . DIRECTORY_SEPARATOR;
    private $nf;
    private $message;
    private $product;
      
    public function __construct()
    {
        parent::__construct();
        /*$this->nf = new \NumberFormatter("hr-HR", \NumberFormatter::DECIMAL);
        $this->nf->setPattern('#,##0.00 kn');*/
        $this->product = new stdClass();
        $this->product->item_name='';
        $this->product->item_price='';
        $this->product->item_description='';
        $this->product->item_image='';
    }

    public function index()
    {
        $product = Product::read();
       
        /*foreach($products as $product){
            $product->item_price=$this->nf->format($product->item_price);
        }*/

       $this->view->render($this->viewDir . 'index',[
           'products' => $product,
       ]);
    }   

    public function add()
    {
        $this->view->render($this->viewDir . 'add',[
            'message'=>'',
            'product'=>$this->product
        ]);
    }

    public function change($id)
    {
        $this->product = Product::readOne($id);

        /*if($this->product->item_price==0){
            $this->product->item_price='';
        }else{
            $this->product->item_price=$this->nf->format($this->product->item_price);
        }*/

        $this->view->render($this->viewDir . 'change',[
            'message'=>'Change data',
            'product'=>$this->product
        ]);
    }

    public function addNew()
    {
        $this->prepareData();

        if($this->controlName()
        && $this->controlPrice()
        && $this->controlDescription()){
            Product::create((array)$this->product);
            header('location:' . App::config('url').'product/index');
        }else{
            $this->view->render($this->viewDir.'add',[
                'message'=>$this->message,
                'product'=>$this->product
            ]);
        }
       
    }

    public function changeNew()
    {
        $this->prepareData();

        if($this->controlName()
        && $this->controlPrice()
        && $this->controlDescription()){
            Product::update((array)$this->product);
            header('location:' . App::config('url').'products/index');
        }else{
            $this->view->render($this->viewDir.'change',[
                'message'=>$this->message,
                'product'=>$this->product
            ]);
        }
       
    }

    public function delete($id)
    {
        Product::delete($id);
        header('location:' . App::config('url').'products/index');
    }

    private function controlName()
    {
        if(strlen($this->product->item_name)===0){
            $this->message='Item name important!';
            return false;
        }
        if(strlen($this->product->item_name)>50){
            $this->message='Item can have only 50 letters';
            return false;
        }

        return true;
    }

    private function controlPrice()
    {
        if(strlen(trim($this->product->item_price))>0){

            $this->product->item_price = str_replace('.','',$this->product->item_price);
            $this->product->item_price = (float)str_replace(',','.',$this->product->item_price);
            if($this->product->item_price<=0){
                $this->message='Price need to be decimal number' 
            . $this->product->item_price;
            $this->product->item_price='';
            return false;
            }
        }

        return true;
    }

    private function controlDescription()
    {
        if(strlen($this->product->item_description)===0){
            $this->message='Item description important!';
            return false;
        }
        if(strlen($this->product->item_description)>500){
            $this->message='Item can have only 300 letters';
            return false;
        }

        return true;
    }
}