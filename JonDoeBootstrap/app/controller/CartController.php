<?php

class CartController extends AuthorizationController
{

    private $viewDir = 
                'private' . DIRECTORY_SEPARATOR . 
                    'cart' . DIRECTORY_SEPARATOR;


     public function index()
    {
        $this->view->render($this->viewDir . 'index',[
        'cart' => Cart::read()
        ]);
    } 

    public  function addtocart($customerId, $productId){
        if (isset($customerId) && isset($productId)){
            $param = array(
                "customer_id" => $customerId,
                "product_id" => $productId
            );

            
            $result = $this->insertintocart($param);
            if ($result){
                
                header('location:' . App::config('url').'cart/index');
            }
        }
    }

    public function removefromcart($productid)
    {
        $customerId = $_SESSION['authorized']->id;
        $cartId = Cart::getCart($customerId)->id;

        echo Cart::removefromcart($productId, $cartId) ? 'OK' : 'Error';
    }
}