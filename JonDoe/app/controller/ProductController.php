<?php

class ProductController extends LoginController
{
    public function index()
    {
       $this->view->render('product');
    }   
}