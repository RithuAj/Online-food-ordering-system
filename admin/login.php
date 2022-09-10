<?php include('../config/constants.php')?>

<html>
    <head>
        <title>Login Food Order System</title>
        <link rel="stylesheet" href="../css/admin.css?">
    </head>
    <body>
        <div class="login">
            <h1 class="text-center">Login</h1>
            <br><br>

            <?php
            if(isset($_SESSION['login']))
            {
             echo $_SESSION['login'];//Displaying session message
             unset($_SESSION['login']);//Removing session message
            }
            if(isset($_SESSION['no-login-message']))
            {
             echo $_SESSION['no-login-message'];//Displaying session message
             unset($_SESSION['no-login-message']);//Removing session message
            }
            ?>
         <br><br>
          <!--Login Form starts here-->
            <form action="" method="POST" class="text-center">
            Username:<br>
            <input type="text" name="username" placeholder="Enter username"><br><br>

            Password:<br>
            <input type="password" name="password" placeholder="Enter password"><br><br>
            
            <input type="submit" name="submit" value="Login" class="btn-primary">
            <br><br>
            </form>

           <!--Login Form ends here-->
            <p class="text-center">Created By <a href="www.maithiliandrithu.com"> Rithu A Jalgar</a></p>
        </div>
    </body>
</html>

<?php
//Check whether the submit button is clicked or not
if(isset($_POST['submit']))
{
    //Process for login
    //1.Get the data from Login Form
    $username=$_POST['username'];
    $password=md5($_POST['password']);

    //2.SQL to check whether the username and password exist or not
    $sql="SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

    //3.Execute the query
    $res=mysqli_query($conn,$sql);

    //4.Count rows to check whether the user exist or not
    $count=mysqli_num_rows($res);

    if($count==1)
    {
        //User available and Login success
        $_SESSION['login']="<div class='success'>Login Successfull</div>";
        //To check whether the user is logged in or not and Logout will unset it
        $_SESSION['user']=$username;
        //Redirect to Home page or Dashboard
        header('location:'.SITEURL.'admin/');
    }
    else{
        //User not available and Login Fail
        $_SESSION['login']="<div class='error text-center'>Username or Password did not match</div>";
        //Redirect to Login page
        header('location:'.SITEURL.'admin/login.php');
    }
}

?>