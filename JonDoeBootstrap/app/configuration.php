<?php

if($_SERVER['SERVER_ADDR']==='127.0.0.1'){
    $url='http://jondoe.xyz/';
    $dev=true;
    $data=[
        'server'=>'localhost',
        'data'=>'edunovapp24',
        'user'=>'edunova',
        'password'=>'edunova'
    ];
}else{
    $url='https://polaznik39.edunova.hr/';
    $dev=false;
    $data=[
        'server'=>'localhost',
        'data'=>'junona_edunovapp24',
        'user'=>'junona',
        'password'=>'fsdfsdf'
    ];
}

return [
    'dev'=>$dev,
    'url'=>$url,
    'titleApp'=>'John Doe Tailoring',
    'data'=>$data
];


