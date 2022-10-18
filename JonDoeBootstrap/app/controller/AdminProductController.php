<?php

class AdminProductController extends AuthorizationController
{
    private $viewDir = 
                'private' . DIRECTORY_SEPARATOR . 
                'adminProduct' . DIRECTORY_SEPARATOR;

    private $product;
    private $nf;
    private $message;

    public function __construct()
    {
        parent::__construct();
        
        $this->product = new stdClass();
        $this->product->id=0;
        $this->product->item_name='';
        $this->product->price = 1.00;
        $this->product->item_description='';      
        $this->product->inventoryquantity = '';
        $this->product->dateadded = '';
        $this->product->lastUpdated = '';
        $this->product->imageInput = '';

        $this->nf = new \NumberFormatter("hr-HR", \NumberFormatter::DECIMAL);
        $this->nf->setPattern('#,##0.00');

        $this->message = new stdClass();
        $this->message->item_name='';
        $this->message->item_description='';
        $this->message->price='';
        $this->message->inventoryquantity='';
        $this->message->imageInput='';
    }

    public function index()
    {
        if(!isset($_GET['search'])){
            $search = '';
        }else{
            $search = $_GET['search'];
        }

        if(!isset($_GET['page'])){
            $page = 1;
        }else{
            $page = (int)$_GET['page'];
        }
        if($page == 0){
            $page = 1;
        }

        $totalProducts = Product::totalProducts($search);
        $totalPages = ceil($totalProducts / App::config('ppp'));

        if($page > $totalPages){
            $page = $totalPages;
        }
        $products = Product::read($search, $page);
        
        foreach($products as $product){
            $product->price=$this->nf->format($product->price);
        }

        $this->view->render($this->viewDir . 'index', [
            'products' => $products,
            'totalProducts' => $totalProducts,
            'page'=>$page,
            'totalPages'=>$totalPages,
        ]);
    } 

    public function details($id=0)
    {
        if($id==0){
            $this->view->render($this->viewDir . 'details', [
                'product'=>$this->product,
                'message'=>$this->message,
                'action'=>'Add new product.',
                'javascript'=>'<script src="' . App::config('url') . 'public/js/vendor/cropper.js"></script>
                                <script src="' . App::config('url') . 'public/js/custom/savePicture.js"></script> 
                                <script src="' . App::config('url') . 'public/js/custom/productTable.js"></script>'
                                
            ]);
        }else{
            $this->product = Product::readOne($id);
            $this->getPicture($this->product->id);

            if($this->product->price==0){
                $this->product->price = '';
            }else{
                $this->product->price = $this->nf->format($this->product->price);
            }

            $this->view->render($this->viewDir . 'details', [
                'product'=>$this->product,
                'message'=>$this->message,
                'action'=>'Save.',
                'javascript'=>'<script src="' . App::config('url') . 'public/js/vendor/cropper.js"></script>
                                <script src="' . App::config('url') . 'public/js/custom/savePicture.js"></script> 
                                <script src="' . App::config('url') . 'public/js/custom/productTable.js"></script>'
            ]);
        }

    }

    public function action()
    {
        $this->product = (object)$_POST;

        if($this->product->id == 0){
            if($this->validationName() &&
                $this->validationImage() &&
                $this->validationDescription() &&
                $this->validatePrice() &&
                $this->validateInventoryQuantity() &&
                $this->validationImage()){
                    $id = AdminProduct::create((array)$this->product);
                    $this->savePicture($id);
            }else{
                $this->view->render($this->viewDir . 'details',[
                    'product'=>$this->product,
                    'message'=>$this->message,
                    'action'=>'Add new product.',
                    'javascript'=>'<script src="' . App::config('url') . 'public/js/vendor/cropper.js"></script>
                                <script src="' . App::config('url') . 'public/js/custom/savePicture.js"></script> 
                                <script src="' . App::config('url') . 'public/js/custom/productTable.js"></script>'
                ]);
                return;
            }
        }else{
            if($this->validationName() &&
                $this->validationImage() &&
                $this->validationDescription() &&
                $this->validatePrice() &&
                $this->validateInventoryQuantity() &&
                $this->validationImage()){
                    $id = AdminProduct::create((array)$this->product);
                    $this->savePicture($id);
            }else{
                $this->view->render($this->viewDir . 'details',[
                    'product'=>(object)$_POST,
                    'message'=>$this->message,
                    'action'=>'Save.',
                    'javascript'=>'<script src="' . App::config('url') . 'public/js/vendor/cropper.js"></script>
                                <script src="' . App::config('url') . 'public/js/custom/savePicture.js"></script> 
                                <script src="' . App::config('url') . 'public/js/custom/productTable.js"></script>'
                ]);
                return;
            }
        }
        header('location:' . App::config('url').'product/index');

    }

    public function delete($id)
    {
        Product::delete($id);
        header('location:' . App::config('url').'product/index');
    }

    private function savePicture($id)
    {
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

    private function getPicture()
    {
            $this->product->imageInput = base64_encode(file_get_contents(BP . 'public' . DIRECTORY_SEPARATOR
                                                                        . 'images' . DIRECTORY_SEPARATOR . 
                                                                        'product' . DIRECTORY_SEPARATOR 
                                                                        . $this->product->id . '.png'));

    }
    

    private function validationName()
    {
        if(strlen(trim($this->product->item_name))===0){
            $this->message='You must enter item name!';
            return false;
        }
        if(strlen($this->product->item_name)>50){
            $this->message='Item name can not be longer then 50 characters!';
            return false;
        }
        return true;
    }

    private function validationImage()
    {
        if(strlen(trim($this->product->imageInput)) === 0){
            $this->message->imageInput = 'Image is important.';
            return false;
        }
        return true;
    }

    private function validationDescription()
    {
        if(strlen(trim($this->product->item_description))===0){
            $this->message='You must enter description!';
            return false;
        }
        if(strlen($this->product->item_description)>100){
            $this->message='Description can not be longer then 100 characters!';
            return false;
        }
        return true;
    }

    private function validatePrice()
    {
        if($this->product->price == ''){
            $this->message->price = 'Price can not be 0.';
            return false;
        }
        if(strlen(trim($this->product->price)) > 0){
            $this->product->price = str_replace('.','',$this->product->price);
            $this->product->price = (float)str_replace(',','.',$this->product->_price);
            
            if($this->product->price <= 0){
                $this->message->price = 'Price need to be decimal number.';
                $this->product->price = 1.00;
            return false;
            }
        }
        return true;
    }

    private function validateInventoryQuantity()
    {
        if($this->product->inventoryquantity<0){
            $this->message->inventoryquantity='Can`t be a 0.';
            return false;
        }
        return true;
    }

}