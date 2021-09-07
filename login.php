<?php 
   session_start();

   if((!isset($_POST['login'])) || (!isset($_POST['password']))){
      header('Location: index.php');
      exit();
   }

   require_once "connect.php";
   mysqli_report(MYSQLI_REPORT_STRICT);

   try {
      $connection = new mysqli($host, $db_user, $db_password, $db_name);
      if($connection->connect_errno!=0){
         echo '1';
         throw new Exception(mysqli_connect_errno());
      }
      else{
         $login = $_POST['login'];
         $password = $_POST['password'];
         $login = htmlentities($login, ENT_QUOTES, "UTF-8");
         echo '2';
         if($result = $connection->query(sprintf("SELECT * FROM users WHERE nick='%s'", mysqli_real_escape_string($connection, $login)))){
            echo '3';
            $users = $result->num_rows;
            if($users>0){
               echo '4';
               $row = $result->fetch_assoc();
               if(password_verify($password, $row['password'])){
                  $_SESSION['zalogowany'] = true;
                  $_SESSION['user'] = $row['nick'];
                  $_SESSION['email'] = $row['email'];
                  $_SESSION['admin'] = $row['admin'];
                  $id = $row['id'];
                  $sql = "SELECT * FROM characters WHERE id = '$id'";
                  $result2 = $connection->query($sql);
                  $row2 = $result2->fetch_assoc();
                  if($row2['name'] == ''){
                     $_SESSION['tocreate'] = true;
                  }
                  $_SESSION['name'] = $row2['name'];
                  $_SESSION['class'] = $row2['class'];
                  $_SESSION['race'] = $row2['race'];
                  $_SESSION['level'] = $row2['level'];
                  $_SESSION['exp'] = $row2['exp'];
                  unset($_SESSION['e_login']);
                  $result->free_result();
                  $result2->free_result();
                  header('Location: main.php');
               }
               else{
                  $_SESSION['e_login'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
                  header('Location: index.php');
               }
            }
         }
      }
      $connection->close();
   } 
   catch (Exception $e) {
      echo 'Błąd serwera!</br>';
      echo $e;
   }
?>