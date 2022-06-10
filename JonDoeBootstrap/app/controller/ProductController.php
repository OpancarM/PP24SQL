<?php

class ProductController extends AuthorizationController
{
    private $viewDir = 
                'private' . DIRECTORY_SEPARATOR . 
                    'products' . DIRECTORY_SEPARATOR;

    private $message;
    private $product;
      
    public function __construct()
    {
        parent::__construct();
        $this->product = new stdClass();
        $this->product->id=0;
        $this->product->item_name='';
        $this->product->item_price='';
        $this->product->item_description='';
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
                'message'=>'Add data',
                'action'=>'Add new',
                'javascript'=>'<script src="' . App::config('url') . 'public/js/cropper.js"></script>
                                <script src="' . App::config('url') . 'public/js/saveimg.js"></script> '
            ]);
        }else{
            $this->view->render($this->viewDir . 'details',[
                'product'=>Product::readOne($id),
                'message'=>'Change data',
                'action'=>'Change',
                'javascript'=>'<script src="' . App::config('url') . 'public/js/cropper.js"></script>
                                <script src="' . App::config('url') . 'public/js/saveimg.js"></script> '
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

        header('location:' . App::config('url').'predavac/index');

    }

    public function delete($id)
    {
        Product::delete($id);
        header('location:' . App::config('url').'product/index');
    }
}