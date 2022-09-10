<?php include('partials/menu.php')?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Rating</h1>

        <br/>
        <br/>
        <table class="tbl-full">
            <tr>
                <th>S.N</th>
                <th>Customer Name</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Remarks</th>
            </tr>

            <?php
               //get all the details from database
               $sql="SELECT * FROM tbl_rating";

               $res=mysqli_query($conn,$sql);

               $count=mysqli_num_rows($res);

               $sn=1;

               if($count>0)
               {
                  while($row=mysqli_fetch_assoc($res))
                  {
                   //get all the deatails
                   $id=$row['id'];
                   $customer_name=$row['customer_name'];
                   $customer_contact=$row['customer_contact'];
                   $customer_email=$row['customer_email'];
                   $remarks=$row['remarks'];
               

               ?>
               <tr>
               <td><?php echo $sn++;?></td>
               <td><?php echo $customer_name;?></td>
                <td><?php echo $customer_contact;?></td>
                <td><?php echo $customer_email;?></td>
                <td><?php echo $remarks;?></td>
               </tr>

               <?php
               }
            }
               else{
                //details not available
                echo "<tr><td colspan='12' class='error'>Details Not Available</td></tr>";
            }

?>
        </table>
    </div>
</div>



<?php include('partials/footer.php')?>