<?php

require "signOut.php";

session_start();
if(!isset($_SESSION['info'])){
  $_SESSION['info'] = [];
}

if(isset($_POST['name']) 
  && isset($_POST['lastName'])
  && isset($_POST['city']) 
  && isset($_POST['adress']) 
  && count($_POST)===4){
    $_SESSION['info'][]=$_POST;
}
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
    <div class="container">
      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                              
        <label for="name">NAME</label><br>
        <input type="text" name="name" id="name" placeholder="name"/><br>

        <label for="lastName">LAST NAME</label><br>
        <input type="text" name="lastName" id="lastName" placeholder="last name"/><br>

        <label for="city">CITY</label><br>
        <input type="text" name="city" id="city" placeholder="city"/><br>

        <label for="adress">ADRESS</label><br>
        <input type="text" name="adress" id="adress" placeholder="adress"/><br>

        <input type="submit" value="Submit" class="button" />
              
      </form><br>            
            <ol>  
              <?php foreach($_SESSION['info'] as $p): ?> 
              <li><?php echo $p['name'] . ' ' .
                $p['lastName'] . ' ' . 
                $p['city'] . ' ' .
                $p['adress'] ?>
              </li>
              <?php endforeach; ?>
            </ol>  
            <br>
      <form method="post">
        <input type="hidden" name="signOut" value="1"/>
        <input type="submit" class="button1" value="SIGN OUT"/>
      </form>
    </div>
  </section>
</body>
</html>