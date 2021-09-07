<?php 

   session_start();

   if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany'] == true)){
      header('Location: main.php');
      exit();
   }
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="media/style.css">
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <title>eden</title>
</head>
<body>
   <nav class="navigation">
      <span class="logo">domaszk</span>
      <ul class="menu">
         <li class="menu__item"><a href="index.php">logowanie / rejestracja</a></li>
         <li class="menu__item"><a href="info.php">o projekcie</a></li>
         <li class="menu__item"><a href="contact.php">kontakt</a></li>
      </ul>
   </nav>
   <div class="form-box">
      <h1><span class="logo">eden</span></h1>
      <p>dziesięć słów zawrzeć w jednym</p>
      <?php 
      if(isset($_SESSION['e_login'])) echo $_SESSION['e_login'];
      ?>
      <form action="login.php" method="POST">
         <input type="text" name="login" id="name" placeholder="nick"/>
         <input type="password" name="password" id="e-mail" placeholder="hasło"/>
         <button class="submit">zaloguj</button>
         <p>nie masz konta? utwórz je za darmo <a href="registration.php">tutaj</a></p>
      </form>
   </div>

   
</body>
</html>