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

    public function addtocart($productId , $quantity=1, $pizza=false)
    {
        $customerId = $_SESSION['authorized']->id;

        if (Cart::getCart($customerId) === null) {
            Cart::create($customerId);
        }
        $cartId = Cart::getCart($customerId)->id;



        echo Cart::addtocart($productId, $cartId) ? 'OK' : 'Error';
    }

    public function removefromcart($productId)
    {
        $customerId = $_SESSION['authorized']->id;
        $cartId = Cart::getCart($customerId)->id;

        echo Cart::removefromcart($productId, $cartId) ? 'OK' : 'Error';
    }
}