<?php


class Program
{

    private $info;

    public function __construct()
    {
        $this->info=[];
        $this->title();
    }

    private function menu()
    {
        echo '1. Phone view' . PHP_EOL;
        echo '2. Add phone' . PHP_EOL;
        echo '3. Change phone' . PHP_EOL;
        echo '4. Delete phone' . PHP_EOL;
        echo '5. Exit' . PHP_EOL;
        $choice=0;
        while(true){
            $choice = Entry::loadInt('Chose from menu: ','You did not input whole number');
            if($choice<1 || $choice>5){
                echo 'You did not enter a possible choice' . PHP_EOL;
                continue;
            }
            break;
        }
        switch($choice){
            case 1:
                $this->viewPhone();
                break;
            case 2:
                $this->addPhone();
                break;
            case 3:
                $this->changePhone();
                break;
            case 4:
                $this->deletePhone();
                break;
            case 5:
                echo 'Thanks and goodbye!';
        }
    }

    private function deletePhone()
    {
        for($i=0;$i<count($this->info);$i++){
            echo ($i+1) . '. ' . $this->info[$i]->getModel(). PHP_EOL;
        }
        $delete = Entry::loadInt('Chose number to delete: ');
       
        array_splice($this->info,$delete-1,1);
        $this->menu();
    }

    private function changePhone()
    {
        for($i=0;$i<count($this->info);$i++){
            echo ($i+1) . '. ' . $this->info[$i]->getBrand() . ' ' . $this->info[$i]->getModel() . ': ' . $this->info[$i]->getPrice() . PHP_EOL;
        }
        echo '1. Change Brand' . PHP_EOL;
        echo '2. Change Model' . PHP_EOL;
        echo '2. Change Price' . PHP_EOL;
        echo '4. Exit' . PHP_EOL;
        $change=0;

        while(true){
            $change = Entry::loadInt('Chose from menu: ','You did not input whole number');
            if($change<1 || $change>4){
                echo 'You did not enter a possible choice' . PHP_EOL;
                continue;
            }
            break;
        }        

        switch($change){
            case 1:
                $this->info[$i]->setBrand();
                break;
            case 2:
                $this->info[$i]->setModel();
                break;
            case 3:
                $this->info[$i]->setPrice();
                break;
                case 4:
                    echo 'Thanks and goodbye!';
        }
        $this->menu();
    }

    private function addPhone()
    {
        $o = new Phone();
        $o->setId(Entry::loadInt('Entry id: '));
        $o->setBrand(Entry::loadString('Enter brand: '));
        $o->setMOdel(Entry::loadString('Enter model: '));
        $o->setPrice(Entry::loadFloat('Enter price: '));
        $this->info[]=$o;
        $this->menu();
    }

    private function viewPhone()
    {
        $sum=0;
        foreach($this->info as $o){
            $sum+=$o->getPrice();
            echo $o->getBrand() . ' ' . $o->getModel() . ': ' . $o->getPrice() . PHP_EOL;
        }
        if(count($this->info)>0){
            echo 'Averge price: ' . ($sum/count($this->info)) . PHP_EOL;
        }
        $this->menu();
    }

    private function title()
    {
        echo '---------------' . PHP_EOL;
        echo 'PHONE INVENTORY' . PHP_EOL;
        echo '---------------' . PHP_EOL  . PHP_EOL;
        $this->menu();
    }
    
}