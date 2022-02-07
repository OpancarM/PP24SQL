<?php 

$info=[];

function menu()
{
    echo '1. Check person' . PHP_EOL;
    echo '2. Add new person' . PHP_EOL;
    echo '3. Exit from program' . PHP_EOL;
    echo 'Choice: ';
    $terminal = fopen('php://stdin','r');
    $addUser = fgets($terminal);
    switch(addUser){
        case 1:
            printExisting();
            break;
        case 2:
            addNewPerson();
            break;
        case 3:
            break;
    }
}

function printExisting()
{
    if(count($GLOBALS['info'])===0){
        echo 'No existing user' . PHP_EOL;
    }else{
        foreach($GLOBALS['info'] as $person){
            echo $person->name . ' ' . $person->lastName . PHP_EOL;
        }
    }
    
    menu();
}

function addNewPerson()
{
    $persopn = new stdClass();
    echo 'Add name: ';
    $terminal = fopen('php://stdin','r');
    $addUser = fgets($terminal);
    $person->name = str_replace(["\n","\r"], '', $addUser);
    echo 'Unesi prezime: ';
    $person->lastName = str_replace(["\n","\r"], '', fgets($terminal));
    $GLOBALS['info'][]=$person;
    info();
}


