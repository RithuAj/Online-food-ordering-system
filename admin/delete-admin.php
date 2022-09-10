<?php
//Include constants.php here
include('../config/constants.php');

  //1.get the id of the admin to be deleted

  $id=$_GET['id'];

  //2.Create SQL Query to delete admin
  $sql="DELETE FROM tbl_admin WHERE id=$id";

  //Execute the query
  $res=mysqli_query($conn,$sql);

  //Check whether the query is executed successfully or not
  if($res==TRUE)
  {
      //Query excuted successfully and Admin Deleted
      //echo "Admin deleted";
      //Create session variable to display message
      $_SESSION['delete']="<div class='success'>Admin deleted Successfully</div>";
      //Redirect to Manage Admin Page
      header('location:'.SITEURL.'admin/manage-admin.php');
  }
  else{
      //Failed to delete the admin
      //echo "Failed to delete";
      $_SESSION['delete']="<div class='error'>Failed to Delete Admin. Try again later</div>";
      header('location:'.SITEURL.'admin/manage-admin.php');
  }

  //3.Redirect to manage-admin page with message (success/failure)

?>