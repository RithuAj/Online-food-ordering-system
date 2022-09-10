<?php include('partials-front/menu.php');?>



    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>



            <?php
                //dsiplay all the categories tht are actice
                $sql="SELECT * FROM tbl_category WHERE ACTIVE='Yes'";

                //execute the query 
                $res= mysqli_query($conn,$sql);


                //count rows to check whether the category is available or not
                $count=mysqli_num_rows($res);
                //CHECK WHETHER CATEGORY IS AVAILABLE
                if($count>0)
                {
                    //category is available
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //get the values like id,title ,image name
                        $id=$row['id'];
                        $title=$row['title'];
                        $image_name=$row['image_name'];
                        ?>
                        <a href="<?php echo SITEURL;?>category-foods.php?category_id=<?php echo $id;?>">
                            <div class="box-3 float-container">


                            <?php
                            if($image_name=="")
                            {
                                //image is notavailable
                                echo "<div class='error'>Image not found</div>";
                            }
                            else{
                                //image is available
                                ?>
                               
                                
                                <img src="<?php echo SITEURL;?>images/category/<?php echo $image_name?>" alt="Pizza" class="img-responsive img-curve">
                                <?php
                            }
                            
                            
                            ?>

                                <h3 class="float-text text-white "><?php echo $title;?></h3>
                            </div>
                        </a>
                        
                        <?php
                    }
                }
                    else
                    {
                       //Categories not available
                       echo "<div class='error'>Categories not available</div>";
                    }   
            
            
            ?>

            

            
            

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->


    
<?php include('partials-front/footer.php');?>