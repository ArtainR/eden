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
   <link rel="stylesheet" href="media/style2.scss">
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <title>eden</title>
</head>

<body>
   <div class="info">
      <h1 class="info__title"><?php echo $_SESSION['name']?></h1>
      <p class="info__paragraph">
         
      </p>
      <ul class="info__filters filters">
         <li class="filters__item">
            <button class="filters__button filters__button--active">zadania</button>
         </li>
         <li class="filters__item">
            <button class="filters__button">panel postaci</button>
         </li>
         <li class="filters__item">
            <button class="filters__button">wiadomości</button>
         </li>
         <?php
            if ($_SESSION['admin'] == 1) {
               echo '<li class="filters__item"><a href="admin_panel.php"><button class="filters__button">admin</button></a></li>';
            }
         ?>
         <li class="filters__item">
            <a href="logout.php"><button class="filters__button  filters__button--logout">wyloguj</button></a>
         </li>
      </ul>
   </div>
   <div class="container">
      <div class="item">
         <div class="item__header">
            <h2 class="item__title">szaman: czwarty żywioł</h2>
         </div>
         <div class="item__content">
            <p class="item__paragraph">
               zadanie klasowe: uzbrojenie czarodzieja
            </p>
            <button class="item__button button">ukończ</button>
         </div>
      </div>
      <div class="item">
         <div class="item__header">
            <h2 class="item__title">tytuł zadania</h2>
         </div>
         <div class="item__content">
            <p class="item__paragraph">
               tekst zadania
            </p>
            <button class="item__button button">licznik (jeżeli czas dobiegnie końca licznik zamienia się w napis "ukończ")</button>
         </div>
      </div>
      
   </div>
</body>

</html>