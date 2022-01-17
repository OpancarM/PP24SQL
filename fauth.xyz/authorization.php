<?php

if(!isset($_POST['id'])){
    header('location: index.php');
    exit;
}

if($_POST['id']!=10){
    header('location: index.php');
    exit;
}


session_start();
$_SESSION['authorization']=10;
header('location: private.php');