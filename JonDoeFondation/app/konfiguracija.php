<?php

if($_SERVER['SERVER_ADDR']==='127.0.0.1'){
    $url='http://jondoe.xyz/';
    $dev=true;
    $baza=[
        'server'=>'localhost',
        'baza'=>'edunovapp24',
        'korisnik'=>'edunova',
        'lozinka'=>'edunova'
    ];
}else{
    $url='https://polaznik39.edunova.hr/';
    $dev=false;
    $baza=[
        'server'=>'localhost',
        'baza'=>'junona_edunovapp24',
        'korisnik'=>'junona',
        'lozinka'=>'vcbcbc'
    ];
}

return [
    'dev'=>$dev,
    'url'=>$url,
    'rps'=>10,
    'naslovApp'=>'Jon Doe plesni klub',
    'baza'=>$baza
];
