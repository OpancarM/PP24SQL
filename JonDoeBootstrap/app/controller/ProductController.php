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
        $this->product->id=0;
        $this->product->item_name='';
        $this->product->item_price='';
        $this->product->item_description='';
    }

    public function index()
    {
        $product = Product::read();

       $this->view->render($this->viewDir . 'index',[
           'products' => $product,
       ]);
    }   

    public function details($id=0)
    {
        if($id===0){
            $this->view->render($this->viewDir . 'details',[
                'product'=>$this->product,
                'message'=>'Add data',
                'action'=>'Add new'
            ]);
        }else{
            $this->view->render($this->viewDir . 'details',[
                'product'=>Product::readOne($id),
                'message'=>'Change data',
                'action'=>'Change'
            ]);
        }

    }

    public function action()
    {
        if($_POST['id']==0){
            Product::create($_POST);
        }else{
            Product::update($_POST);
        }
        header('location:' . App::config('url').'product/index');

    }

    public function delete($id)
    {
        Product::delete($id);
        header('location:' . App::config('url').'product/index');
    }
}