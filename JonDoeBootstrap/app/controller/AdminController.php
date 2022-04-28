<?php

abstract class AdminController extends AuthorizationController
{
    public function __construct()
    {
        parent::__construct();
        if($_SESSION['authorized']->operatorrole!=='admin'){
            $this->view->render('login',[
                'email'=>'',
                'poruka'=>'First log in'
            ]);
            exit;
        }
    }
}