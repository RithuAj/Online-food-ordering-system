<?php
    //Authorisation-Access Control
   //Check whether the user is logged in or not
if(!isset($_SESSION['user']))//If user session is not set
{
    //User not logged in
    
    $_SESSION['no-login-message']="<div class='error text-center'>Please Login to access Admin Panel.</div>";
    //Redirect to Login page
    header("location:".SITEURL.'admin/login.php');
}

?>