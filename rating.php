<?php include('partials-front/menu.php');?>


<section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Fill this form to give Feedback</h2>

            <form action="" class="order" method="POST">
                
                
                <fieldset>
                    <legend>RATE US</legend>
                    <div class="order-label">Your Name</div>
                    <input type="text" name="full-name" placeholder="E.g. Rithu A Jalgar" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="E.g. hi@gmail.com" class="input-responsive" required>

                    <div class="order-label">Remarks</div>
                    <textarea name="remarks" rows="10" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Rate Now" class="btn btn-primary">
                </fieldset>

            </form>

            <?php
                //check whether button is pressed or not
                if(isset($_POST['submit']))
                {
                    //get all the details from Form
                    $customer_name=$_POST['full-name'];
                    $customer_contact=$_POST['contact'];
                    $customer_email=$_POST['email'];
                    $remarks=$_POST['remarks'];

                    //create sql to save the data
                    $sql="INSERT INTO tbl_rating SET
                    customer_name='$customer_name',
                    customer_contact='$customer_contact',
                    customer_email='$customer_email',
                    remarks='$remarks'
                    ";
                    //execute the query
                    $res=mysqli_query($conn,$sql);
                    //check whether query executed or not
                  if($res==true)
                {
                    //query executed and order saved
                    $_SESSION['remarks']="<div class='success text-center'>Feedback Placed Successfully</div>";
                    //redirect
                    header('location:'.SITEURL);
                }
                else{
                    //failed to save order
                    $_SESSION['remarks']="<div class='error text-center'>Failed to place the Feedback</div>";
                    //redirect
                    header('location:'.SITEURL);
                }
                }
            ?>

            
                
                
            

            

        </div>
    </section>

<?php include('partials-front/footer.php');?>