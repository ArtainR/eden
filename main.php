<?php
session_start();

if (!isset($_SESSION['zalogowany'])) {
   header('Location: index.php');
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
         <li class="menu__item"><a href="logout.php">wyloguj</a></li>
         <?php
         if ($_SESSION['admin'] == 1) {
            echo '<li class="menu__item"><a href="admin_panel.php">admin</a></li>';
         }
         ?>
         <li class="menu__item"><a href="user_panel.php">akcja</a></li>
         <li class="menu__item"><a href="character.php">postać</a></li>
      </ul>
   </nav>
   <div class="form-box">
      <h1><span class="logo">
            <?php
            echo $_SESSION['name'];
            ?>
         </span></h1>
      <p>
         <?php
         echo "Witaj " . $_SESSION['race'] . " " . $_SESSION['class'] . "!";
         ?>
      </p>
   </div>
</body>

</html>