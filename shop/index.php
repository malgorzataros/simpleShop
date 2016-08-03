<?php
 require_once '../src/User.php';
 require_once '../src/connection.php';
 
 session_start();
 
 if (!isset($_SESSION ['loggedUserId'])){
     header("Location: login.php");
 }
 $loggedUser = (int)$_SESSION['loggedUserId'];
 ?>
<a href="logout.php"> Logout </a>
<br><br>

<a href="messageFromAdmin.php">Wiadomosci</a>
<br><br>


