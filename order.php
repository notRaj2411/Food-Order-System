<?php include('partials-front/menu.php'); ?>

    <?php 
        //CHeck whether food id is set or not
        if(isset($_GET['food_id']))
        {
            //Get the Food id and details of the selected food
            $food_id = $_GET['food_id'];

            //Get the DEtails of the SElected Food
            $sql = "SELECT * FROM tbl_food WHERE food_id=$food_id";
            //Execute the Query
            $res = mysqli_query($conn, $sql);
            //Count the rows
            $count = mysqli_num_rows($res);
            //CHeck whether the data is available or not
            if($count==1)
            {
                //WE Have DAta
                //GEt the Data from Database
                $row = mysqli_fetch_assoc($res);

                $title = $row['title'];
                $price = $row['price'];
                $image_name = $row['image_name'];
                $category_id=$row['category_id'];
            }
            else
            {
                //Food not Availabe
                //REdirect to Home Page
                header('location:'.SITEURL);
            }
        }
        else
        {
            //Redirect to homepage
            header('location:'.SITEURL);
        }
    ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

            <form action="" method="POST" class="order">
                <fieldset>
                    <legend>Selected Food</legend>

                    <div class="food-menu-img">
                        <?php 
                        
                            //CHeck whether the image is available or not
                            if($image_name=="")
                            {
                                //Image not Availabe
                                echo "<div class='error'>Image not Available.</div>";
                            }
                            else
                            {
                                //Image is Available
                                ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                <?php
                            }
                        
                        ?>
                        
                    </div>
    
                    <div class="food-menu-desc">
                        <h3><?php echo $title; ?></h3>
                        <input type="hidden" name="food" value="<?php echo $title; ?>">

                        <p class="food-price">₹<?php echo $price; ?></p>
                        <input type="hidden" name="price" value="<?php echo $price; ?>">

                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">First Name</div>
                    <input type="text" name="first-name" placeholder="E.g. Lov" class="input-responsive" required>
                    <div class="order-label">Last Name</div>

                    <input type="text" name="last-name" placeholder="E.g. Kumar" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="E.g. lov@hyderabad.bits-pilani.ac.in" class="input-responsive" required>

                    <div class="order-label">Street Address</div>
                    <textarea name="street-address" rows="5" placeholder="E.g. Street" class="input-responsive" required></textarea>
                    <div class="order-label">Pincode</div>
                    <textarea type="number" name="pincode" rows="1" placeholder="E.g. 500078" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>

            </form>

            <?php 

//CHeck whether submit button is clicked or not
if(isset($_POST['submit']))
{
    // Get all the details from the form

    $food = $_POST['food'];
    $price = $_POST['price'];
    $qty = $_POST['qty'];

    $total = $price * $qty; // total = price x qty 

    $order_date = date("Y-m-d h:i:sa"); //Order Date

    //generating order id from date and time of the order
    $order_id = date("dmYhis".rand(0,9));
    //$order_id = (int)$order_id;
    echo $order_id;

    $status = "Ordered";  // Ordered, On Delivery, Delivered, Cancelled

    $customer_first_name = $_POST['first-name'];
    $customer_last_name = $_POST['last-name'];
    $customer_contact = $_POST['contact'];
    $customer_email = $_POST['email'];
    $customer_street_address = $_POST['street-address'];
    $customer_pincode = $_POST['pincode'];

    $sql9="SELECT * FROM tbl_admin ORDER BY RAND() LIMIT 1";
    $res9 = mysqli_query($conn, $sql9);
    $row9 = mysqli_fetch_assoc($res9);

    $a_id=$row9['id'];


    //$a_id=rand(17,18);
    //Save the Order in Databaase
    //Create SQL to save the data
    
    $sql2 = "INSERT INTO tbl_order SET 
        order_id = '$order_id',     
        total_price = $total,
        order_date = '$order_date',
        order_status = '$status',
        admin_id = $a_id,
        customer_email = '$customer_email'
        
    ";


    $sql3= "INSERT INTO tbl_contains SET 
      order_id = $order_id,
      food_id = '$food_id',
      qty = $qty,
      category_id = $category_id
    ";


    $sql4 = "INSERT INTO tbl_customer
     (customer_email,customer_first_name,customer_last_name,customer_contact, customer_street_address,customer_pincode) 
     VALUES ('$customer_email','$customer_first_name','$customer_last_name','$customer_contact','$customer_street_address',$customer_pincode)            
            ON DUPLICATE KEY UPDATE    
            customer_first_name = '$customer_first_name',
            customer_last_name = '$customer_last_name',
            customer_contact = '$customer_contact',
            customer_street_address = '$customer_street_address',
            customer_pincode = $customer_pincode

    ";

    //echo $sql2; die();

    //Execute the Query
    $res4 = mysqli_query($conn, $sql4);

    $res2 = mysqli_query($conn, $sql2);
    if($res2==true){
    $res3 = mysqli_query($conn, $sql3);
    
    }

    //Check whether query executed successfully or not
    if($res2 ==true && $res3==true && $res4==true)
    {
        //Query Executed and Order Saved
        $_SESSION['order'] = "<div class='success text-center'>Food Ordered Successfully.</div>";
        header('location:'.SITEURL);
    }
    else
    {
        //Failed to Save Order
        $_SESSION['order'] = "<div class='error text-center'>Failed to Order Food.</div>";
        header('location:'.SITEURL);
    }

}

?>

</div>
</section>
<!-- fOOD sEARCH Section Ends Here -->

<?php include('partials-front/footer.php'); ?>