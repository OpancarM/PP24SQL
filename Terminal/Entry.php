<?php

class Entry
{
    public static function loadInt(
        $message='Load whole number: ',
        $messageError='You did not enter whole number.')
    {
        $terminal = fopen('php://stdin','r');
        while(true){
            echo $message;
            $phoneEntry = (int)fgets($terminal);
            if($phoneEntry!=0){
                return $phoneEntry;
            }
            echo $messageError . PHP_EOL;
        }
    }

    public static function loadFloat(
        $message='Load decimal number: ',
        $messageError='You did not enter decimal number.')
    {
        $terminal = fopen('php://stdin','r');
        while(true){
            echo $message;

            $s=fgets($terminal);

            $s = trim($s); 
            $s = str_replace(' ','',$s);
            $s = str_replace('.','',$s);
            $s = str_replace(',','.',$s);

            $phoneEntry = (float)$s;
            
            if($phoneEntry!=0){
                return $phoneEntry;
            }
            echo $messageError . PHP_EOL;
        }
    }


    public static function loadString(
        $message='Load text: ',
        $messageError='You did not load text.')
    {
        $terminal = fopen('php://stdin','r');
        while(true){
            echo $message;
            $phoneEntry =fgets($terminal);
            $phoneEntry = preg_replace("/\r|\n/", "", $phoneEntry);
            if(strlen($phoneEntry)>0){
                return $phoneEntry;
            }
            echo $messageError . PHP_EOL;
        }
    }
}