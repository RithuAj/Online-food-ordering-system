<?php 
include('../config/constants.php');
//echo"delete page";
//check whether id and image_name is set or not
if(isset($_GET['id']) AND isset($_GET['image_name']))
{
   //get the value and delete 
    //echo 'get value and delete';
    $id=$_GET['id'];
    $image_name=$_GET['image_name'];

    //remove the physical image filr if available 

    if($image_name!='')
    {
        //image is available,so remove it
        $path="../images/category/".$image_name;

        //remove the image
        $remove=unlink($path);
        

         //if failed to remove the image add an error message and stop the process
        if($remove==FALSE)
        {
           //set the session message 
            $_SESSION['remove']="<div class='error'>Failed to remove the category image.</div>";
            // redirect manage-category page 
            header("location:".SITEURL.'admin/manage-category.php');
           // stop the process
           die();
        }
    }
    
    
    //delete the data from database
    //SQL QUERY TO DELETE DATA FROM DATABASE
    $sql="DELETE from tbl_category where id=$id";
    //EXECUTE THE QUERY
    $res=mysqli_query($conn,$sql);

    //check wherther the data is deleted from the database or not
    if($res==TRUE)
    {
        //set sucess message and redirect 
        $_SESSION['delete'] = '<div class="success">Category deleted sucessfully</div>';
        //redirect to manage category
        header("location:".SITEURL.'admin/manage-category.php');
    }
    else{
        //set failure message and redirect

        $_SESSION['delete'] = '<div class="error">Failed to delete category</div>';
        //redirect to manage category
        header("location:".SITEURL.'admin/manage-category.php');
    }

    //redirect to manage to manage-category page with messgae


}
else
{
    //redirect to manage_category page
    header('location:'.SITEURL.'admin/manage-category.php');
}


?>