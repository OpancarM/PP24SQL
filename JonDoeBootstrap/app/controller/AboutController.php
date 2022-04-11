<?php

class AboutController extends LoginController
{
    public function index()
    {
       $this->view->render('about');
    }   
}