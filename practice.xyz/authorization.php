<?php

if(!isset($_POST['id'])){
    header('location: index.php');
    exit;
}

if($_POST['id']!=username){
   header('location: index.php');
   exit;
}





session_start();
$_SESSION['authorization']=username;
header('location: private.php');