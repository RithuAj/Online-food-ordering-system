<?php
include('partials/menu.php');?>
<div class="main-content">
    <div class="wrapper">
        <h1>Order Log Book</h1>
        <br><br>


        <table class="tbl-full">
                    <tr>
                        <th width="10%">S.NO</th>
                        <th width="10%">Order Id</th>
                        <th width="10%">Action</th>
                        <th width="15%">Date and Time</th>
                        
                        
                        
                    </tr>

                    <?php 
                        //Get all the orders from database
                        $sql = "SELECT * FROM order_log "; 
                        //Execute Query
                        $res = mysqli_query($conn, $sql);
                        //Count the Rows
                        $count = mysqli_num_rows($res);

                        $sn = 1; //Create a Serial Number and set its initail value as 1

                        if($count>0)
                        {
                            //Order Available
                            while($row=mysqli_fetch_assoc($res))
                            {
                                //Get all the order details
                                
                                $order_id = $row['order_id'];
                                $action = $row['action'];
                                $datetime = $row['date_time'];
                                
                                ?>

                                    <tr>
                                        <td><?php echo $sn++; ?> </td>
                                        <td><?php echo $order_id; ?></td>
                                        <td><?php echo $action; ?> </td>
                                        <td><?php echo $datetime; ?></td>
                                    </tr>
                                    <?php

                            }
                        }
                
                        else
                        {
                            //Order not Available
                            echo "<tr><td colspan='12' class='error'> No Orders updated.</td></tr>";
                        }
                ?>

 
                </table>
    </div>
    
</div>

<?php include('partials/footer.php'); ?>