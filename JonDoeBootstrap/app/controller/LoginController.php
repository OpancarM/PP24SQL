<?php

class LoginController extends Controller
{
    public function index()
    {
        $this->loginView('Add email and password','');
    }

    public function authorization()
    {
        if(!isset($_POST['email']) || !isset($_POST['userpassword'])){
            $this->index();
            return;
        }

        if(strlen(trim($_POST['email']))===0){
           $this->loginView('Email required','');
           return;
        }

        if(strlen(trim($_POST['userpassword']))===0){
            $this->loginView('Password required',$_POST['email']);
            return;
         }
        
         $operator = Operator::authorization($_POST['email'],$_POST['userpassword']);
         if($operator==null){
             $this->loginView('Wrong email and password',$_POST['email']);
             return;
         }

         $_SESSION['authorized']=$operator;
         $np = new DashboardController();
         $np->index();

    }

    public function logout()
    {
        unset($_SESSION['authorized']);
        session_destroy();
        $this->loginView('Succesful logout','');
    }

    private function loginView($message,$email)
    {
        $this->view->render('login',[
            'message'=>$message,
            'email'=>$email
        ]);
    }
}


