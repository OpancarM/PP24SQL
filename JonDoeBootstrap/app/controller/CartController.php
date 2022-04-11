<?php

class CartController extends AuthorizationController
{

    private $viewDir = 
                'private' . DIRECTORY_SEPARATOR . 
                    'cart' . DIRECTORY_SEPARATOR;

    public function index()
    {
       $this->view->render($this->viewDir . 'index');
    }  
}