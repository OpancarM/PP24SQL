<?php

class OrdersController extends AuthorizationController
{
    private $viewDir = 
                'public' . DIRECTORY_SEPARATOR . 
                    'orders' . DIRECTORY_SEPARATOR;



    public function __construct()
    {
        parent::__construct();
        $this->nf = new \NumberFormatter("hr-HR", \NumberFormatter::DECIMAL);
        $this->nf->setPattern('#,##0.00');
                
        $this->customer = new stdClass();
        $this->customer->id = null;
        $this->customer->firstname = '';
        $this->customer->lastname = '';
        $this->customer->email = '';
        $this->customer->phonenumber = '';
        $this->customer->street = '';
        $this->customer->city = '';
        $this->customer->postalnumber = '';
        $this->customer->cardnumber = '';
        $this->customer->cvv = '';

        $this->message = new stdClass();
        $this->message->firstname = '';
        $this->message->lastname = '';
        $this->message->email = '';
        $this->message->phonenumber = '';
        $this->message->street = '';
        $this->message->city = '';
        $this->message->postalnumber = '';
        $this->message->email = '';
        $this->message->cardnumber = '';
        $this->message->cvv = '';
                        
                    }

    public function index()
    {
        $orders=Orders::getOrderCart($_SESSION['authorized']->id);

        $this->view->render($this->viewDir . 'index', [
            'orders' =>$orders,
            'javascript' => '<script src="' . App::config('url') . 'public/js/custom/removeFromCart.js"></script> '
        ]);
    }

    public function finalized()
    {
        $orders = Orders::getOrderCart($_SESSION['authorized']->id);
        foreach ($orders as $product) {
            $product->priceFormatted = $this->nf->format($product->item_price);
        }
        $this->customer = Customer::readOne($_SESSION['authorized']->id);

        $this->view->render($this->viewDir . 'finalized', [
            'orders' => $orders,
            'customer' => $this->customer,
            'message' => $this->message,
            'javascript' => '<script src="' . App::config('url') . 'public/js/custom/removeFromCart.js"></script> '
        ]);
    }

    public  function addToCart($productId, $quantity=1){
        {
            $customerId = $_SESSION['authorized']->id;
            if (Orders::getOrderCart($customerId) == null) {
                Orders::create($customerId);
            }
            $ordersId = Orders::getOrder($customerId)->id;
            
            $this->view->render($this->viewDir . 'index', [
                'orders' =>$orders
            ]);
    
    
            echo Cart::addToCart($productId, $ordersId, $quantity)? 'OK' : 'Error';
        }
        
    }

    public function removeFromCart($productId)
    {
        $customerId = $_SESSION['authorized']->id;
        $ordersId = Orders::getOrder($customerId)->id;

        echo Orders::removeFromCart($productId, $ordersId) ? 'OK' : 'Error';
    }

    public function numberofuniqueproducts()
    {
        echo Orders::numberOfUniqueProducts($_SESSION['authorized']->id);
    }

    public function action()
    {
        $this->customer=(object)$_POST;

        if (

            $this->validateFirstname() &&
            $this->validateLastname() &&
            $this->validateEmail() &&
            $this->validatePhonenumber() &&
            $this->validateStreet() &&
            $this->validateCity() &&
            $this->validatePostalnumber() &&
            $this->validateCardnumber() &&
            $this->validateCvv()

        ) {
            Orders::finishOrder($this->customer->id);
            header('location: ' . App::config('url') . 'dashboard/index');
        } else {
            $orders = Orders::getShoppingorderCart($_SESSION['authorized']->id);
            foreach ($orders as $product) {
                $product->priceFormatted = $this->nf->format($product->price);
            }

            $this->view->render($this->viewDir . 'finalized', [
                'orders' => $orders,
                'customer' => (object)$_POST,
                'message' => $this->message,
                'javascript' => '<script src="' . App::config('url') . 'public/js/custom/removeFromCart.js"></script> '

            ]);

            return;
        }
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

    private function validateCardnumber()
    {
        if (strlen(trim($this->customer->cardnumber)) < 16) {
            $this->message->cardnumber = 'Card has minimum 16 numbers.';
            return false;
        }
        return true;
    }

    private function validateCvv()
    {
        if (strlen(trim($this->customer->cvv)) != 3) {
            $this->message->cvv = 'CVV has 5 numbers.';
            return false;
        }
        return true;
    }
}