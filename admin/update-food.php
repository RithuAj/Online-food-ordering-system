
<?php include('partials/menu.php')?>

<?php
    //Check whether id is set or not
    if(isset($_GET['id']))
    {
        //get all details
        $id=$_GET['id'];

        //sql query to get the selected food
        $sql2="SELECT * FROM tbl_food WHERE id=$id";

        $res2=mysqli_query($conn,$sql2);

        //get the value based on query executed
        $row2=mysqli_fetch_assoc($res2);

        //get the individual value of selected food
        $title=$row2['title'];
        $description=$row2['description'];
        $price=$row2['price'];
        $current_image=$row2['image_name'];
        $current_category=$row2['category_id'];
        $featured=$row2['featured'];
        $active=$row2['active'];
    }
    else{
        //redirect to manage-food
        header('location:'.SITEURL.'admin/manage-food.php');
    }
    ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">
          <table class="tbl-30">

            <tr>
                <td>Title:</td>
                <td>
                    <input type="text" name="title" value="<?php echo $title ?>">
                </td>
            </tr>
            <tr>
                <td>Description:</td>
                <td>
                    <textarea name="description" cols="30" rows="5"><?php echo $description ?></textarea>
                </td>
            </tr>
            <tr>
                <td>Price:</td>
                <td>
                    <input type="number" name="price" value="<?php echo $price ?>">
                </td>
            </tr>
            <tr>
                <td>Current Image:</td>
                <td>
                    <?php
                        if($current_image=="")
                        {
                            //image not availabe
                            echo "<div class='error'>Image not Available</div>";
                        }
                        else{
                            //image available
                            ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" alt="<?php echo $title ?>" width="150px">

                            <?php
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td>Select New Image:</td>
                <td>
                    <input type="file" name="image" >
                </td>
            </tr>
            <tr>
                <td>Category:</td>
                <td>
                    <select name="category">
                    <?php
                      $sql="SELECT * FROM tbl_category WHERE active='Yes'";

                      $res=mysqli_query($conn,$sql);

                      //Count rows
                      $count=mysqli_num_rows($res);
                    if($count>0)
                      {
                          //We have category
                          while($row=mysqli_fetch_assoc($res))
                          {
                              //get the details of category
                              $category_id=$row['id'];
                              $category_title=$row['title'];
                              ?>
                                <option <?php if($current_category==$category_id){echo "selected";}?> value="<?php echo $category_id;?>"><?php echo $category_title; ?></option>

                              <?php
                          }
                      }
                      else{
                          //We donot have category
                          ?>
                          <option value="0">Category not available</option>
                          <?php
                      }
                    ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Featured:</td>
                <td>
                    <input <?php if($featured=="Yes"){echo "checked";}?> type="radio" value="Yes" name="featured" >Yes
                    <input <?php if($featured=="No"){echo "checked";}?> type="radio" value="No" name="featured" >No
                </td>
            </tr>
            <tr>
                <td>Active:</td>
                <td>
                    <input <?php if($active=="Yes"){echo "checked";}?> type="radio" value="Yes" name="active" >Yes
                    <input <?php if($active=="No"){echo "checked";}?> type="radio" value="No" name="active" >No
                </td>
            </tr>
            <tr>
                <td colspan="2">
                
                <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                    <input type="hidden" name="id" value="<?php echo $id;?>">
                    <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                </td>
            </tr>
          </table>   
</form>
<?php
   if(isset($_POST['submit']))
   {
      // echo "button clicked";

      //1.get all the details from the Form
      $id=$_POST['id'];
      $title=$_POST['title'];
      $description=$_POST['description'];
      $price=$_POST['price'];
      $current_image=$_POST['current_image'];
      $category=$_POST['category'];
      $featured=$_POST['featured'];
      $active=$_POST['active'];

      //2.upload the image if selected
      if(isset($_FILES['image']['name']))
      {
          //upload button clicked
          $image_name=$_FILES['image']['name'];//new image name

          //check whether the file is available or not
          if($image_name!="")
          {
              //image is availble
              //A.uploading new image
              //rename the image name
              $image_name=explode('.',$image_name);
              $ext=end($image_name);
              $image_name="Food-Name-".rand(0000,9999).'.'.$ext;

              $src_path=$_FILES['image']['tmp_name'];

              $dest_path="../images/food/".$image_name;

            //finally upload the image
              $upload=move_uploaded_file( $src_path, $dest_path);

              //check whether image is uploaded or not
              if($upload==false)
              {
                  //failed to upload
                  $_SESSION['upload']="<div class='error'>Failed to upload new image</div>";
                  //redirect
                  header('location:'.SITEURL.'admin/manage-food.php');
                  //stop the process
                  die();
              }
              //3.remove the image if new image is uploaded and current image exits
              //B.remove current image if available
              if($current_image!="")
              {
                  //current image is availble
                  //remove the image
                  $remove_path="../images/food/".$current_image;
                  $remove=unlink($remove_path);
                    //check whether the image is removed or not
                  if($remove==false)
                  {
                      //failed to remove current
                      $_SESSION['remove-failed']="<div class='error'>Failed to remove current image</div>";
                      //redirect
                      header('location:'.SITEURL.'admin/manage-food.php');
                      //stop the process
                      die();
                  }
              }
          }
          else{
            $image_name=$current_image;
          }
      }
      else{
          $image_name=$current_image;
      }
    //4.update the food in database
      $sql3="UPDATE tbl_food SET
       title='$title',
       description='$description',
       price=$price,
       image_name='$image_name',
       category_id=$category,
       featured='$featured',
       active='$active'
       WHERE id=$id
      ";

      //execute the sql query
      $res3=mysqli_query($conn,$sql3);

      //check whether the query is executed or not
      if($res3==true)
      {
          //query executed and food updated
          $_SESSION['update']="<div class='success'>Food Updated Successfully</div>";
          header('location:'.SITEURL.'admin/manage-food.php');
      }
      else{
          //failed to upadate food
          $_SESSION['update']="<div class='error'>Failed to Update Food</div>";
          header('location:'.SITEURL.'admin/manage-food.php');
       }
    }


?>
    </div>
</div>




<?php include('partials/footer.php')?>
