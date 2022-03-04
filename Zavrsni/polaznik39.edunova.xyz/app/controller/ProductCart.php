<?php

class ProductController extends AuthorizationController
{

    private $viewDir = 
                'private' . DIRECTORY_SEPARATOR . 
                    'products' . DIRECTORY_SEPARATOR;

    public function index()
    {
       $this->view->render($this->viewDir . 'index');
    }   
}