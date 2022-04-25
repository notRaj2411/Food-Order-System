<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Order</h1>
        <br><br>


        <?php 
        
            //CHeck whether id is set or not
            if(isset($_GET['id']))
            {
                //GEt the Order Details
                $order_id=$_GET['id'];

                //Get all other details based on this id
                //SQL Query to get the order details
                $sql = "SELECT * FROM tbl_order WHERE order_id=$order_id";
                //Execute Query
                $res = mysqli_query($conn, $sql);
                //Count Rows
                $count = mysqli_num_rows($res);

                if($count==1)
                {
                    //Detail Availble
                    $row=mysqli_fetch_assoc($res);

                   // $food = $row['food'];
                   // $price = $row['total_price'];
                  //  $qty = $row['qty'];
                    $status = $row['order_status'];
                   
                    $customer_email = $row['customer_email'];
                   // $customer_address= $row['customer_address'];
                   
                   $sql = "SELECT * FROM tbl_customer WHERE customer_email='$customer_email' ";
                   //Execute Query
                   $res = mysqli_query($conn, $sql);
                   $row=mysqli_fetch_assoc($res);
                   $customer_first_name = $row['customer_first_name'];
                   $customer_last_name = $row['customer_last_name'];
                   $customer_contact = $row['customer_contact'];
                   $customer_street_address=$row['customer_street_address'];
                   $customer_pincode=$row['customer_pincode'];

                   $sql = "SELECT * FROM tbl_contains WHERE order_id='$order_id' ";
                   //Execute Query
                   $res = mysqli_query($conn, $sql);
                   $row=mysqli_fetch_assoc($res);
                   
                   $qty = $row['qty'];
                   $food_id = $row['food_id'];

                   //query to get food title from food table
                   $sql="SELECT * FROM tbl_food WHERE food_id=$food_id ";
                   //Execute Query
                   $res = mysqli_query($conn, $sql);
                   $row=mysqli_fetch_assoc($res);
                   $food= $row['title'];
                   $price = $row['price'];



                }
                else
                {
                    //DEtail not Available/
                    //Redirect to Manage Order
                    header('location:'.SITEURL.'admin/manage-order.php');
                }
            }
            else
            {
                //REdirect to Manage ORder PAge
                header('location:'.SITEURL.'admin/manage-order.php');
            }
        
        ?>

        <form action="" method="POST">
        
            <table class="tbl-30">
                <tr>
                    <td>Food Name</td>
                    <td><b> <?php echo $food; ?> </b></td>
                </tr>

                <tr>
                    <td>Price</td>
                    <td>
                        <b> $ <?php echo $price; ?></b>
                    </td>
                </tr>

                <tr>
                    <td>Qty</td>
                    <td>
                        <input type="number" name="qty" value="<?php echo $qty; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Status</td>
                    <td>
                        <select name="status">
                            <option <?php if($status=="Ordered"){echo "selected";} ?> value="Ordered">Ordered</option>
                            <option <?php if($status=="On Delivery"){echo "selected";} ?> value="On Delivery">On Delivery</option>
                            <option <?php if($status=="Delivered"){echo "selected";} ?> value="Delivered">Delivered</option>
                            <option <?php if($status=="Cancelled"){echo "selected";} ?> value="Cancelled">Cancelled</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Customer First Name: </td>
                    <td>
                        <input type="text" name="customer_first_name" value="<?php echo $customer_first_name; ?>">
                    </td>
                    <td>Customer Last Name: </td>
                    <td>
                        <input type="text" name="customer_last_name" value="<?php echo $customer_last_name; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Customer Contact: </td>
                    <td>
                        <input type="text" name="customer_contact" value="<?php echo $customer_contact; ?>">
                    </td>
                </tr>


                <tr>
                    <td>Customer Street Address: </td>
                    <td>
                        <textarea name="customer_street_address" cols="30" rows="5"><?php echo $customer_street_address; ?></textarea>
                    </td>
                    <td>Customer Pincode: </td>
                    <td>
                        <textarea name="customer_pincode" cols="20" rows="1"><?php echo $customer_pincode; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td clospan="2">
                        <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                        <input type="hidden" name="price" value="<?php echo $price; ?>">    
                        <input type="hidden" name="customer_email" value="<?php echo $customer_email; ?>">
                    
                </tr>

                        <input type="submit" name="submit" value="Update Order" class="btn-secondary">
                    </td>
                </tr>
            </table>
        
        </form>


        <?php 
            //CHeck whether Update Button is Clicked or Not
            if(isset($_POST['submit']))
            {
                //echo "Clicked";
                //Get All the Values from Form
                $order_id = $_POST['order_id'];
                $price = $_POST['price'];
                $qty = $_POST['qty'];

                $total = $price * $qty;

                $status = $_POST['status'];

                $customer_first_name = $_POST['customer_first_name'];
                $customer_last_name = $_POST['customer_last_name'];
                $customer_contact = $_POST['customer_contact'];
                $customer_email = $_POST['customer_email'];
                $customer_street_address = $_POST['customer_street_address'];
                $customer_pincode = $_POST['customer_pincode'];

                //Update the Values in order table
                $sql2 = "UPDATE tbl_order SET 
                    total_price = $total,
                    order_status = '$status'
                    WHERE order_id='$order_id'
                ";

                $sql3 = "UPDATE tbl_customer SET 
                    
                    customer_first_name = '$customer_first_name',
                    customer_last_name = '$customer_last_name',
                    customer_contact = '$customer_contact',
                    customer_street_address = '$customer_street_address'
                    WHERE customer_email='$customer_email'
                ";

                $sql4 = "UPDATE tbl_contains SET 
                    qty=$qty
                    
                    WHERE order_id='$order_id'
                ";

                //Execute the Query
                $res2 = mysqli_query($conn, $sql2);
                $res3 = mysqli_query($conn, $sql3);
                $res4 = mysqli_query($conn, $sql4);

                //CHeck whether update or not
                //And REdirect to Manage Order with Message
                if($res2==true&& $res3==true&& $res4==true)
                {
                    //Updated
                    $_SESSION['update'] = "<div class='success'>Order Updated Successfully.</div>";
                    header('location:'.SITEURL.'admin/manage-order.php');
                }
                else
                {
                    //Failed to Update
                    $_SESSION['update'] = "<div class='error'>Failed to Update Order.</div>";
                    header('location:'.SITEURL.'admin/manage-order.php');
                }
            }
        ?>


    </div>
</div>

<?php include('partials/footer.php'); ?>