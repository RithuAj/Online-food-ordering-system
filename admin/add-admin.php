<?php include('partials/menu.php')?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br />


        <?php
        if(isset($_SESSION['passlength']))
        {
            echo $_SESSION['passlength'];
            unset($_SESSION['passlength']);
        }


        ?>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name:</td>
                    <td><input type="text" name="full_name" placeholder="Enter your name"></td>
                </tr>
                <tr>
                    <td>User Name:</td>
                    <td><input type="text" name="username" placeholder="Enter your username"></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    
                    <td><input type="password" name="password" placeholder="Enter Password"></td>   
                    
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>
    </div>
</div>

<?php include('partials/footer.php')?>



<?php
  
if(isset($_POST['submit']))
{
    

            
        

    
//Process the value from Form and Save it in Database
//Check whether the submit button is clicked or not
   //Button clicked
    //echo "Button clicked";

   
    
        $password=($_POST['password']);
       // Validate password strength
$uppercase=preg_match('@[A-Z]@',$password);
$lowercase=preg_match('@[a-z]@',$password);
$number=preg_match('@[0-9]@',$password);
$specialChars=preg_match('@[^\w]@',$password);
if(!empty($_POST['password']))
{

                if(!$uppercase||!$lowercase||!$number||!$specialChars||strlen($password)<8)
                {
                    $_SESSION['passlength']="<div class='error text-center'>Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one specialcharacter.!</div>";
                    //Redirect to Login page
                    header('location:'.SITEURL.'admin/add-admin.php');
                }

                else
                {
                    echo 'Strong password.';
                    //1.get data from form
                    $full_name=$_POST['full_name'];
                    $username=$_POST['username'];

                    $password=md5($_POST['password']);//password encryption with md5
                    
                    //2.sql query to save the data into database
                    $sql="INSERT INTO tbl_admin SET
                    full_name='$full_name',
                    username='$username',
                    password='$password'
                    ";
                    //echo $sql;

                    //3.Executing query and saving data into database
                    $res=mysqli_query($conn,$sql) or die(mysqli_error());
                    //Check whether the data is inserted or not and display the appropriate message
                    if($res==TRUE)
                    {
                        //data inserted
                        //echo "Data inserted";
                        //Create a Session variable to Display message
                        $_SESSION['add']='<div class="success">Admin Added Successfully</div>';
                        //Redirect Page to manage admin
                        header('location:http://localhost/food-order/admin/manage-admin.php');
                    }
                    else
                    {
                        //failed to insert data
                        //echo "Failed to insert data";
                        //Create a Session variable to Display message
                        $_SESSION['add']='<div class="error">Failed to add admin</div>';
                        //Redirect Page to manage admin
                        header("location:".SITEURL.'admin/add-admin.php');

                    }
                }
                    

        }
        else{
            echo "please enter the password";
        }
    }


                
                ?>