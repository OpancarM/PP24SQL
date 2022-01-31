<?php

session_start();
 
if (isset($_POST["signOut"])) { unset($_SESSION["username"]); }
 
if (!isset($_SESSION["username"])) {
  header("Location: index.php");
  exit();
}