<?php 

   session_start();
   if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany'] == true)){
      header('Location: main.php');
      exit();
   }

   if(isset($_POST['emal'])){
      // nick
      $isAllOK = true;
      $nick = $_POST['login'];
      if(strlen($nick) < 3 || strlen($nick) > 16){
         $isAllOK = false;
         $_SESSION['e_nick'] = 'Nick musi posiadać od trzech do szesnastu znaków';
      }
      if(!ctype_alnum($nick)){
         $isAllOK = false;
         $_SESSION['e_nick'] = 'Nick może składać się tylko z liter i cyfr (bez polskich znaków)';
      }
      
      // email
      $email = $_POST['email'];
      $emailFiltered = filter_var($email, FILTER_SANITIZE_EMAIL);
      if((filter_var($emailFiltered, FILTER_VALIDATE_EMAIL)== false) || ($emailFiltered != $email)){
         $isAllOK = false;
         $_SESSION['e_email'] = 'Niepoprawny format email!';
      }

      // password
      $pass1 = $_POST['password'];
      $pass2 = $_POST['repeatpassword'];
      if(strlen($pass1) < 8 || strlen($pass) > 20){
         $isAllOK = false;
         $_SESSION['e_password'] = "Hasło musi posiadać od 8 do 20 znaków";
      }
      if($pass1!=$pass2){
         $isAllOK = false;
         $_SESSION['e_password'] = "Hasła są różne!";
      }

      // hash
      $passHashed = password_hash($pass1, PASSWORD_DEFAULT);

      // checkbox
      if(!isset($_POST['rules'])){
         $isAllOK = false;
         $_SESSION['e_rules'] = "Zaakceptuj regulamin!";
      }

      $_SESSION['r_nick'] = $nick;
      $_SESSION['r_email'] = $email;
      $_SESSION['r_pass1'] = $pass1;
      $_SESSION['r_pass2'] = $pass2;
      if(isset($_POST['rules'])) {
         $_SESSION['rules'] = true;
      }

      require_once "connect.php";
      mysqli_report(MYSQLI_REPORT_STRICT);
      
      try {
         $mysqli = new mysqli($host, $db_user, $db_password, $db_name);
         if($mysqli->connect_errno!=0){
            throw new Exception(mysqli_connect_errno());
         }
         else{
            // check if email is avaible
            $result = $mysqli->query("SELECT id FROM users WHERE email='$email'");
            if(!$result){
               throw new Exception($mysqli->error);
            }
            $emails = $result->num_rows;
            if($emails > 0){
               $isAllOK = false;
               $_SESSION['e_email'] = "Istnieje już konto przypisane do tego adresu e-mail!";
            }
            // check if nickname is avaible
            $result = $mysqli->query("SELECT id FROM users WHERE user='$nick'");
            if(!$result){
               throw new Exception($mysqli->error);
            }
            $nicks = $result->num_rows;
            if($nicks > 0){
               $isAllOK = false;
               $_SESSION['e_nick'] = "Istnieje już gracz o takim nicku!";
            }
            // ok
            if($isAllOK = true){
               if($mysqli->query("INSERT INTO users VALUES (NULL, '$nick', '$email', '$passHashed', now() + INTERVAL 3 DAY, 0)")){
                  if($mysqli->query("INSERT INTO characters VALUES (NULL, '', '', '', 0, 0)")){
                     $_SESSION['success'] = true;
                     header('Location: welcome.php');
                  }
                  else{
                     throw new Exception($mysqli->error);
                  }
               }
               else{
                  throw new Exception($mysqli->error);
               }
            }
            $mysqli->close();
         }
      } catch (Exception $e) {
         echo 'Błąd serwera!';
      }
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
         <li class="menu__item"><a href="index.php">logowanie</a></li>
         <li class="menu__item"><a href="info.php">o projekcie</a></li>
         <li class="menu__item"><a href="contact.php">kontakt</a></li>
      </ul>
   </nav>
   <div class="form-box">
      <h1><span class="logo">rejestracja</span></h1>
      <form class="form" method="post">
         <input type="text" name="login" placeholder="nick" value="<?php 
         if(isset($_SESSION['r_nick'])){
            echo $_SESSION['r_nick'];
            unset($_SESSION['r_nick']);
         }
         ?>"/>
         <?php 
         if(isset($_SESSION['e_nick'])){
            echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
            unset($_SESSION['e_nick']);
         }
         ?>

         <input type="email" name="email" placeholder="e-mail" value="<?php 
         if(isset($_SESSION['r_email'])){
            echo $_SESSION['r_email'];
            unset($_SESSION['r_email']);
         }
         ?>"/>
         <?php 
         if(isset($_SESSION['e_email'])){
            echo '<div class="error">'.$_SESSION['e_email'].'</div>';
            unset($_SESSION['e_email']);
         }
         ?>
         <input type="password" name="password" placeholder="hasło" value="<?php 
         if(isset($_SESSION['r_pass1'])){
            echo $_SESSION['r_pass1'];
            unset($_SESSION['r_pass1']);
         }
         ?>"/>
         <?php 
         if(isset($_SESSION['e_pass1'])){
            echo '<div class="error">'.$_SESSION['e_pass1'].'</div>';
            unset($_SESSION['e_pass1']);
         }
         ?>

         <input type="password" name="repeatpassword" placeholder="powtórz hasło" value="<?php 
         if(isset($_SESSION['r_pass2'])){
            echo $_SESSION['r_pass2'];
            unset($_SESSION['r_pass2']);
         }
         ?>"/>
         <?php 
         if(isset($_SESSION['e_pass1'])){
            echo '<div class="error">'.$_SESSION['e_pass1'].'</div>';
            unset($_SESSION['e_pass1']);
         }
         ?>
         <label>
            <input type="checkbox" name="rules" <?php 
         if(isset($_SESSION['r_rules'])){
            echo "checked";
            unset($_SESSION['r_rules']);
         }
         ?>/> akceptuję <a href="rules.php">regulamin</a>.
         </label>
         <?php 
         if(isset($_SESSION['e_rules'])){
            echo '<div class="error">'.$_SESSION['e_rules'].'</div>';
            unset($_SESSION['e_rules']);
         }
         ?>

         <button class="submit" type="submit">utwórz konto!</button>

      </form>
   </div>

   
</body>
</html>