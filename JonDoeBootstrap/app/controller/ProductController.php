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

    private function savePicture($id){
        $picture = $_POST['imageInput'];
        $picture=str_replace('data:image/png;base64,','',$picture);
        $picture=str_replace(' ','+',$picture);
        $data=base64_decode($picture);

        file_put_contents(BP . 'public' . DIRECTORY_SEPARATOR
        . 'images' . DIRECTORY_SEPARATOR . 
        'product' . DIRECTORY_SEPARATOR 
        . $id . '.png', $data);

        echo "OK";
    }

    private function getPicture(){
            $this->product->imageInput = base64_encode(file_get_contents(BP . 'public' . DIRECTORY_SEPARATOR
                                                                        . 'images' . DIRECTORY_SEPARATOR . 
                                                                        'product' . DIRECTORY_SEPARATOR 
                                                                        . $this->product->id . '.png'));
    }
}