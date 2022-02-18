<?php

class LoginController extends Controller
{
    public function index()
    {
        $this->loginView('Add email and password','');
    }

    public function authorization()
    {
        if(!isset($_POST['email']) || !isset($_POST['password'])){
            $this->index();
            return;
        }

        if(strlen(trim($_POST['email']))===0){
           $this->loginView('Email required','');
           return;
        }

        if(strlen(trim($_POST['lozinka']))===0){
            $this->loginView('Password required',$_POST['email']);
            return;
         }
    }

    private function loginView($message,$email)
    {
        $this->view->render('login',[
            'message'=>$message,
            'email'=>$email
        ]);
    }
}