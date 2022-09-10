<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>

        <?php 
            if(isset($_GET['id']))
            {
                $id=$_GET['id'];

            }
            if(isset($_SESSION['passlength']))
        {
            echo $_SESSION['passlength'];
            unset($_SESSION['passlength']);
        }
        ?>

        <form action="" method="POST">
        
            <table class="tbl-30">
                <tr>
                    <td>Current Password: </td>
                    <td>
                        <input type="password" name="current_password" placeholder="Current Password">
                    </td>
                </tr>

                <tr>
                    <td>New Password:</td>
                    <td>
                        <input type="password" name="new_password" placeholder="New Password">
                    </td>
                </tr>

                <tr>
                    <td>Confirm Password: </td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm Password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>

    </div>
</div>

<?php 

            //CHeck whether the Submit Button is Clicked on Not
if(isset($_POST['submit']))
{
                //echo "CLicked";










                //1. Get the DAta from Form
                $id=$_POST['id'];
                $current_password = md5($_POST['current_password']);
               


                //2. Check whether the user with current ID and Current Password Exists or Not
                $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";

                //Execute the Query
                $res = mysqli_query($conn, $sql);

                if($res==true)
                {
                    //CHeck whether data is available or not
                    $count=mysqli_num_rows($res);

                    if($count==1)
                    {
                        //User Exists and Password Can be Changed
                        //echo "User FOund";


                        //password validation
                        $new_password=($_POST['new_password']);
       // Validate password strength
                        $uppercase=preg_match('@[A-Z]@',$new_password);
                        $lowercase=preg_match('@[a-z]@',$new_password);
                        $number=preg_match('@[0-9]@',$new_password);
                        $specialChars=preg_match('@[^\w]@',$new_password);
                        
                        if(!empty($_POST['new_password']))
                        {

                            if(!$uppercase||!$lowercase||!$number||!$specialChars||strlen($new_password)<8)
                            {
                                 $_SESSION['passlength']="<div class='error text-center'>Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one specialcharacter.!</div>";
                                    //Redirect to Login page
                                    header('location:'.SITEURL.'admin/update-password.php');
                            }
                            else
                            {

                                $new_password = md5($_POST['new_password']);
                                $confirm_password = md5($_POST['confirm_password']);
                                if($new_password!=$confirm_password)
                                {
                                    //REdirect to Manage Admin Page with Error Message
                                    $_SESSION['pwd-not-match'] = "<div class='error'>Password Did not Match. </div>";
                                    //Redirect the User
                                    header('location:'.SITEURL.'admin/manage-admin.php');

                                }
                               

                                         //Check whether the new password and confirm match or not
                                if($new_password==$confirm_password)
                                {

                                    
                                    //Update the Password
                                        $sql2 = "UPDATE tbl_admin SET 
                                        password='$new_password' 
                                        WHERE id=$id
                                        ";

                                    //Execute the Query
                                    $res2 = mysqli_query($conn, $sql2);

                                    //CHeck whether the query exeuted or not
                                        if($res2==true)
                                        {
                                            //Display Succes Message
                                            //REdirect to Manage Admin Page with Success Message
                                            $_SESSION['change-pwd'] = "<div class='success'>Password Changed Successfully. </div>";
                                            //Redirect the User
                                            header('location:'.SITEURL.'admin/manage-admin.php');
                                        }
                                        else
                                        {
                                                //Display Error Message
                                                //REdirect to Manage Admin Page with Error Message
                                                $_SESSION['change-pwd'] = "<div class='error'>Failed to Change Password. </div>";
                                                //Redirect the User
                                                header('location:'.SITEURL.'admin/manage-admin.php');
                                        }
                                }
                               
                            }
                        }
                    else{
                        echo 'please enter the new password';
                    }
                
                
                
                    
                    }
                else
                    {
                        //User Does not Exist Set Message and REdirect
                        $_SESSION['user-not-found'] = "<div class='error'>User Not Found. </div>";
                        //Redirect the User
                        header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                
            

                //3. CHeck Whether the New Password and Confirm Password Match or not

                               }               //4. Change PAssword if all above is true
}
        
    
    
        

?>


<?php include('partials/footer.php'); ?>