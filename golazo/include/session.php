<?php
   include('include/config.php');
   session_start();
   
   //$user_check = $_SESSION['login_user'];
   
   //$ses_sql = mysqli_query($db,"SELECT userName from user where userName = '$user_check' ");
   
   //$row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
   
   $login_session = $_SESSION['login_user'];
   
   if(!isset($_SESSION['login_user'])){
      header("location:login.php");
      die();
   }
?>