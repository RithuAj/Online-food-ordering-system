<?php
  include('../config/constants.php');
  //1.Destroy the session
  session_destroy(); //onsets $_SESSION
  //2.Redirect to Login page
  header('location:'.SITEURL.'admin/login.php');
?>