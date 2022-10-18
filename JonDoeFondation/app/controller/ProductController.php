<?php

class ProductController extends AuthorizationController
{
    private $viewDir = 
                'private' . DIRECTORY_SEPARATOR . 
                    'products' . DIRECTORY_SEPARATOR;
    private $title;
    private $message;
    private $product;
      
    public function __construct()
    {
        parent::__construct();
        $this->product = new stdClass();
        $this->product->id=0;
        $this->product->iname='';
        $this->product->price='';
        $this->product->idescription='';
        $this->product->image_path='';
    }

    public function index()
    {

        $product = Product::read();
        foreach($product as $p){
            if(file_exists(BP . 'public' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR
            . 'products' . DIRECTORY_SEPARATOR . $p->id . '.png' )){
                $p->picture= App::config('url') . 'public/img/products/' . $p->id . '.png';
            }else{
                $p->picture= App::config('url') . 'public/img/products/unkown.png';
            }
        }

       $this->view->render($this->viewDir . 'index',[
           'products' => $product
       ]);
    }   

    public function details($id=0)
    {
        if($id===0){
            $this->view->render($this->viewDir . 'details',[
                'product'=>$this->product,
                'title'=>'Add product',  
                'action'=>'Add new' 
            ]);
        }else{
            $this->view->render($this->viewDir . 'details',[
                'product'=>Product::readOne($id),
                'title'=>'Change product',
                'action'=>'Change'
            ]);
        }

    }

    public function action()
    {
        if($_POST['id']==0){
           $id = Product::create($_POST);
            
        }else{
            Product::update($_POST);
            $id=$_POST['id'];
        }
        header('location:' . App::config('url').'product/index');

        if(isset($_FILES['picture'])){
            move_uploaded_file($_FILES['picture']['tmp_name'], 
            BP . 'public' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR
             . 'products' . DIRECTORY_SEPARATOR . $id . '.jpg'
        );
        }

        header('location:' . App::config('url').'product/index');

    }

    public function delete($id)
    {
        Product::delete($id);
        header('location:' . App::config('url').'product/index');
    }
}