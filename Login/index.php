<?php
require "authorization.php";
?>

<!doctype html>
<html class="no-js" lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homework</title>
    <link rel="stylesheet" href="css/style.css">
  </head>
<body>
  <section>
    <div>
      <?php if (isset($failed)) { ?>
      <div id="bad-login">Invalid user or password.</div>
      <?php } ?> 

      <form  method="post">

        <label for="username">USERNAME</label><br>
        <input type="text" name="username" id="username" placeholder="username"><br>
        <label for="password">PASSWORD</label><br>
        <input type="password" name="password" id="password" placeholder="password" ><br>
        <input type="submit" class="button" value="SIGN IN"> 

      </form>
    </div>
  </section>   
</body>
</html>
