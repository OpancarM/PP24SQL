<?php

return [
    'dev'=>true,
    'url'=>'http://jondoe.xyz/',
    'titleApp'=>'John Doe Tailoring',
    'data'=>[
        'server'=>'localhost',
        'data'=>'edunovapp24',
        'user'=>'edunova',
        'password'=>'edunova'
    ]
];



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
    $baza=[
        'server'=>'localhost',
        'data'=>'junona_edunovapp24',
        'user'=>'junona',
        'password'=>'$2a$12$.a4gBTmAfWqd8gDwlD1oM.hacroGWNd7t6kOxEB1MhK7dqRvYaPoS'
    ];
}

return [
    'dev'=>$dev,
    'url'=>$url,
    'titleApp'=>'John Doe Tailoring',
    'data'=>$data
];


