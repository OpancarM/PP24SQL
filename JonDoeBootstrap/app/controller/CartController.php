<?php

class CartController extends AuthorizationController
{

    private $viewDir = 
                'private' . DIRECTORY_SEPARATOR . 
                    'cart' . DIRECTORY_SEPARATOR;


     public function index()
    {
        $cart=Cart::getInCart($_SESSION['authorized']->id);

        $this->view->render($this->viewDir . 'index', [
            'cart' =>$cart,
        ]);
    } 

    public  function addToCart($productId, $quantity=1){
        {
            $customerId = $_SESSION['authorized']->id;
            if (Cart::getInCart($customerId) == null) {
                Cart::create($customerId);
            }
            $cartId = Cart::getCart($customerId)->id;
            
            $this->view->render($this->viewDir . 'index', [
                'cart' =>$cart,
            ]);
    
    
            echo Cart::addToCart($productId, $cartId, $quantity);
        }
        
    }

    public function removeFromCart($productId)
    {
        $customerId = $_SESSION['authorized']->id;
        $cartId = Cart::getCart($customerId)->id;

        echo Cart::removeFromCart($productId, $cartId);
    }
}