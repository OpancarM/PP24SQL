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
        if(!isset($_GET['page'])){
            $pagea=1;
        }else{
            $page=(int)$_GET['page'];
        }
        if($page==0){
            $page=1;
        }

        if(!isset($_GET['cond'])){
            $cond='';
        }else{
            $cond=$_GET['cond'];
        }

        $up = Product::quntitiProduct($cond);
        $pages = ceil($up / App::config('rps'));
        
        if($page>$pages){
            $page = $pages;
        }

        $product = Product::read();

       $this->view->render($this->viewDir . 'index',[
           'products' => $product,
           'cond'=>$cond,
           'page'=>$page,
           'pages'=>$pages,
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

    public function saveimg(){

        $img = $_POST['image'];
        $img=str_replace('data:image/png;base64,','',$img);
        $img=str_replace(' ','+',$img);
        $data=base64_decode($img);

        file_put_contents(BP . 'public' . DIRECTORY_SEPARATOR
        . 'img' . DIRECTORY_SEPARATOR . 
        'products' . DIRECTORY_SEPARATOR 
        . $_POST['id'] . '.png', $data);

        echo "OK";
    }


    private function addImg($product)
    {
        foreach($product as $p){
            if(file_exists(BP . 'public' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR
            . 'products' . DIRECTORY_SEPARATOR . $p->id . '.png' )){
                $p->image= App::config('url') . 'public/img/products/' . $p->id . '.png';
            }else{
                $p->image= App::config('url') . 'public/img/unkown.png';
            }
        }
        return $product;
    }
}