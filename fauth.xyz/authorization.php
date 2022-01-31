<?php

session_start();
 
if (isset($_POST["username"]) && !isset($_SESSION["username"])) {
  
   $users = [
    "username" => "password",
    "mateo" => "451994",
  ];
 
  if (isset($users[$_POST["username"]])) {
    if ($users[$_POST["username"]] == $_POST["password"]) {
      $_SESSION["username"] = $_POST["username"];
    }
  }
 
  if (!isset($_SESSION["username"])) { $failed = true; }
}
 
if (isset($_SESSION["username"])) {
  header("Location: private.php");
  exit();
}