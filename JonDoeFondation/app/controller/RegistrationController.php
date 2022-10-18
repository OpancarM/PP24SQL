<?php

class RegistrationController extends LoginController
{
    private $customer;
    protected $message;

    public function __construct()
    {
        parent::__construct();
        
        $this->customer = new stdClass();
        $this->customer->id = null;
        $this->customer->firstname = '';
        $this->customer->lastname = '';
        $this->customer->email = '';
        $this->customer->userpassword = '';
        $this->customer->phonenumber = '';
        $this->customer->street = '';
        $this->customer->city = '';
        $this->customer->postalnumber = '';

        $this->message = new stdClass();
        $this->message->firstname='';
        $this->message->lastname='';
        $this->message->email = '';
        $this->message->userpassword = '';
        $this->message->phonenumber = '';
        $this->message->street = '';
        $this->message->city = '';
        $this->message->postalnumber = '';
        $this->message->email = '';
        $this->message->password = '';
    }

    public function index()
    {
        $this->view->render('registration', [
            'customer'=>$this->customer,
            'message'=>$this->message,
            'email'=>$this->email
        ]);
    }

    public function newCustomer(){
        $this->customer = (object) $_POST;

        if($this->validateFirstname() &&
            $this->validateLastname() &&
            $this->validateEmail() &&
            $this->validatePassword() &&
            $this->validatePhonenumber() && 
            $this->validateStreet() &&
            $this->validateCity() &&
            $this->validatePostalnumber()
            ){
            $this->securePassword();

            
            Customer::insert((array)$this->customer);

            $customer = Registration::readOne($this->customer->email);
            $_SESSION['authorized'] = $customer;

            // Redirecting to homepage
            header('location: ' . App::config('url'));
                
        }else{
            $this->index();
            return;
        }
    }

    public function details($id)
    {
        $this->customer = Customer::readOne($id);
        $this->view->render('public/dashboard/details', [
            'customer'=>$this->customer,
            'message'=>$this->message
        ]);
    }

    private function validateFirstname()
    {
        if (strlen(trim($this->customer->firstname)) === 0) {
            $this->message->firstname = 'Name is importante.';
            return false;
        }
        if (strlen(trim($this->customer->firstname)) > 50) {
            $this->message->firstname = 'Name need to have 50.';
            return false;
        }
        return true;
    }

    private function validateLastname()
    {
        if (strlen(trim($this->customer->lastname)) === 0) {
            $this->message->lastname = 'Last name is importante.';
            return false;
        }
        if (strlen(trim($this->customer->lastname)) > 50) {
            $this->message->lastname = 'Last name need to have 50.';
            return false;
        }
        return true;
    }

    private function validateEmail()
    {
        if (filter_var($this->customer->email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            $this->message->email = 'Email wrong format.';
            return false;
        };
    }

    private function validatePassword()
    {
        if(strlen(trim($this->customer->userpassword)) < 4){
            $this->message->userpassword = 'Password need to have minimum 4 letters or numbers';
            return false;
        }
        if($this->customer->userpassword !== $this->customer->userpassword_repeat){
            $this->customer->userpassword_repeat = '';
            $this->message->userpassword_repeat = 'Passwords it is not a same. Try again.';
            return false;
        }
        return true;
    }

    private function validatePhonenumber()
    {
        if (strlen(trim($this->customer->phonenumber)) < 7) {
            $this->message->phonenumber = 'Phone number need to hame minimum 7 numbers.';
            return false;
        }
        if (strlen(trim($this->customer->phonenumber)) > 15) {
            $this->message->phonenumber = 'Phone number can`t have more then 15 numbers.';
            return false;
        }
        return true;
    }

    private function validateStreet()
    {
        if (strlen(trim($this->customer->street)) === 0) {
            $this->message->street = 'Street name and street number is wrong.';
            return false;
        }
        if (strlen(trim($this->customer->street)) > 255) {
            $this->message->street = 'Street name and street number can`t have more then 255 letters .';
            return false;
        }
        return true;
    }

    private function validateCity()
    {
        if (strlen(trim($this->customer->city)) > 50) {
            $this->message->city = 'City can`t have more then 50 letters.';
            return false;
        }
        return true;
    }

    private function validatePostalnumber()
    {
        if (strlen(trim($this->customer->postalnumber)) > 5) {
            $this->message->postalnumber = 'Postal number has 5 numbers.';
            return false;
        }
        return true;
    }

    private function securePassword()
    {
        $this->customer->user_password = password_hash($this->customer->user_password, PASSWORD_BCRYPT);    
        return true;

    }
}