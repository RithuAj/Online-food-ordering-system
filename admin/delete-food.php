<?php
include('../config/constants.php');
 //echo"delete food";


 if(isset($_GET['id']) & isset($_GET['image_name']))
 {
     //process to website
     //echo"process to delete";
     //1.get id and image name

     $id=$_GET['id'];
     $image_name=$_GET['image_name'];

     //2.remove the image if available

     //check whether image is availbale or notand delete only if available
     if($image_name!="")
     {
         //it has image
         //get the image path
         $path="../images/food/".$image_name;

         //remove image file from folder
         $remove=unlink($path);


         //check whether image is removed or not
         if($remove==false)
         {
             //failed to remove the image
             $_SESSION['upload']="<div class='error'>Failed to remove the image file</div>";
             header("location:".SITEURL.'admin/manage-food.php');
             //stop the pricess of deleting the food
             die();

             
         }

     }

    //3.delete food from database
    $sql="DELETE from tbl_food where id=$id";
    //execute the query
    $res=mysqli_query($conn,$sql);
    //check whether query is executed or not and set the session message respectively
     //4.redirect to manage food with message
    if($res==true)
    {
        //food deleted
        $_SESSION['delete']="<div class='success'>Food deleted successfully</div>";
        header("location:".SITEURL.'admin/manage-food.php');

    }
    else{
        //failed to delete the food
        $_SESSION['delete']="<div class='error'>Failed to delete food</div>";
        header("location:".SITEURL.'admin/manage-food.php');
    }
   
 }

 else{
     //redirect to manage food page
     //echo"redirect";
    $_SESSION['unauthorize']="<div class='error'> Unauthorized Access</div>";
    header("location:".SITEURL.'admin/manage-food.php');

 }
?>