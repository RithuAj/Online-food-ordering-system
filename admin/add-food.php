<?php
include('partials/menu.php');?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
        <br><br>

        <?php
          if(isset($_SESSIO['upload']))
          {
              echo $_SESSION['upload'];
              unset($_SESSION['upload']);
          }

?>

        <form action="" method="POST" enctype="multipart/form-data">

        <table class="tbl-30">
            <tr>
                <td>Title:</td>
                <td>
                    <input type="text" name="title" placeholder="Title of the Food">
                </td>
            </tr>
            <tr>
                <td>Description:</td>
                <td>
                    <textarea name="description" cols="30" rows="5" placeholder="Description of the Food"></textarea>
                </td>
            </tr>
            <tr>
                <td>Price:</td>
                <td>
                    <input type="number" name="price" >
                </td>
            </tr>
            <tr>
                <td>Select Image:</td>
                <td>
                    <input type="file" name="image" >
                </td>
            </tr>
            <tr>
                <td>Category:</td>
                <td>
                    <select name="category">

                    <?php
                      //Create PHP Code to display categories from Dtabase
                      //1.Create SQL to get all active categories
                      $sql="SELECT * FROM tbl_category WHERE active='Yes'";
                    //Execute the query
                      $res=mysqli_query($conn,$sql);

                      //Count rows to check whether we have category or not
                      $count=mysqli_num_rows($res);

                      //If count is greater then 0,we have categories else we do not have categories
                      if($count>0)
                      {
                          //We have category
                          while($row=mysqli_fetch_assoc($res))
                          {
                              //get the details of category
                              $id=$row['id'];
                              $title=$row['title'];
                              ?>
                                <option value="<?php echo $id;?>"><?php echo $title; ?></option>

                              <?php
                          }
                      }
                      else{
                          //We donot have category
                          ?>
                          <option value="0">No category found</option>
                          <?php
                      }

                      //2.Display on Dropdown   

                    ?>
                        
                    </select>
                </td>
            </tr>
            <tr>
                <td>Featured:</td>
                <td>
                    <input type="radio" value="Yes" name="featured" >Yes
                    <input type="radio" value="No" name="featured" >No
                </td>
            </tr>
            <tr>
                <td>Active:</td>
                <td>
                    <input type="radio" value="Yes" name="active" >Yes
                    <input type="radio" value="No" name="active" >No
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                </td>
            </tr>
        </table>

        </form>
         <?php
            //Check whether the button is clicked or not
            if(isset($_POST['submit']))
            {
                //Add food in database
                //echo "Clicked";

                //1.Get the data from Form
                $title=$_POST['title'];
                $description=$_POST['description'];
                $price=$_POST['price'];
                $category=$_POST['category'];
                //Check whether radio button is checked or not
                if(isset($_POST['featured']))
                {
                    $featured=$_POST['featured'];
                }
                else{
                    $featured="No";//Setting deafult value
                }
                if(isset($_POST['active']))
                {
                    $active=$_POST['active'];
                }
                else{
                    $active="No";//Setting deafult value
                }

                //2.Upload the Image if selected
                //Check whether the select image is clicked or not and upload image only if the image is selected
                if(isset($_FILES['image']['name']))
                {
                    //Get the detaols of the selected image
                    $image_name=$_FILES['image']['name'];

                    //Check whether the image is selected or not and upload image only if selected
                    if($image_name !="")
                    {
                        //Image is selected
                        //A.Rename the image
                        //get the extension of the selected image like jpg,png,gif etc
                        //$ext=end(expload('.',$image_name));
                        $image_name=explode('.',$image_name);
                        $ext=end($image_name);

                        //Create new name for image
                        $image_name="Food-Name-".rand(0000,9999).".".$ext;//New image name may be like "Food-Name-657.jpeg"

                        //B.Upload image
                        //Get the source path and destination path

                        //source path is the current location of the image
                        $src=$_FILES['image']['tmp_name'];

                        //destination path for image to be uploaded
                        $dst="../images/food/".$image_name;

                        //Finally upload image
                        $upload=move_uploaded_file($src,$dst);

                        //Check whether the image is uploaded or not
                        if($upload==false)
                        {
                            //Failed to upload the image
                            //Redirect to add-food page with error message
                            $_SESSION['upload']="<div class='error'>Failed to Upload Image</div>";
                            header('location:'.SITEURL.'admin/add-food.php');
                            //Stop the process
                            die();
                        }
                    }
                }
                else{
                    $image_name="";//setting default value as blank
                }
                //3.Insert into database

                //Create SQL Query to save or Add food
                $sql2="INSERT INTO tbl_food SET
                   title='$title',
                   description='$description',
                   price='$price',
                   image_name='$image_name',
                   category_id=$category,
                   featured='$featured',
                   active='$active'
                 ";

                 //Execute the query
                 $res2=mysqli_query($conn,$sql2);

                 //Check whether data is inserted or not
                 //4.Redirect with Message to manage-food page

                 if($res2==true)
                 {
                     //data inserted successfully
                     $_SESSION['add']="<div class='success'>Food Added Successfully</div>";
                     header('location:'.SITEURL.'admin/manage-food.php');
                 }
                 else{
                     //Failed TO Insert data
                     $_SESSION['add']="<div class='error'>Failed to Add Food</div>";
                     header('location:'.SITEURL.'admin/manage-food.php');
                 }

                
            }

?>



    </div>
</div>
<?php
include('partials/footer.php');?>