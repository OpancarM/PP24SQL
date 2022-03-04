<?php

class UserController extends AuthorizationController
{

    private $viewDir = 
                'private' . DIRECTORY_SEPARATOR . 
                    'users' . DIRECTORY_SEPARATOR;

    public function index()
    {
       $this->view->render($this->viewDir . 'index');
    }   
}