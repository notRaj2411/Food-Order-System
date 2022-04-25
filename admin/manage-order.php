<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Order</h1>

                <br /><br /><br />

                <?php 
                    if(isset($_SESSION['update']))
                    {
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }
                ?>
                <br><br>

                <table class="tbl-full">
                    <tr>
                        <th>Order No.</th>
                        <th>Food</th>
                        <th>Price</th>
                        <th>Qty.</th>
                        <th>Total</th>
                        <th>Order Date</th>
                        <th>Status</th>
                        <th>Customer Name</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Street Address</th>
                        <th>Pincode</th>
                        <th>Actions</th>
                    </tr>

                    <?php 
                        //Get all the orders from database
                        $sql = "SELECT * FROM tbl_order ORDER BY order_id DESC"; // DIsplay the Latest Order at First
                        //Execute Query
                        $res = mysqli_query($conn, $sql);
                        //Count the Rows
                        $count = mysqli_num_rows($res);


                        if($count>0)
                        {
                            //Order Available
                            while($row=mysqli_fetch_assoc($res))
                            {
                                //Get all the order details
                                $order_id = $row['order_id'];

                                $total = $row['total_price'];
                                $order_date = $row['order_date'];
                                $status = $row['order_status'];
                                $customer_email = $row['customer_email'];
                                
                                ?>

                                <?php

                                    $sql2 = "SELECT * FROM tbl_customer where customer_email = '$customer_email'"; // DIsplay the Latest Order at First
                                    //Execute Query
                                    $res2 = mysqli_query($conn, $sql2);
                                    $row2=mysqli_fetch_assoc($res2);
                                    $customer_name = $row2['customer_first_name'].' '.$row2['customer_last_name'];
                                    //$customer_last_name = $row2['customer_last_name'];
                                    $customer_contact = $row2['customer_contact'];
                                    $customer_street_address = $row2['customer_street_address'];
                                    $customer_pincode = $row2['customer_pincode'];


                                    //getting food_id and qty from contains table
                                    $sql3 = "SELECT * FROM tbl_contains where order_id = '$order_id'"; 
                                    //Execute Query
                                    $res3 = mysqli_query($conn, $sql3);
                                    $row3=mysqli_fetch_assoc($res3);

                                    $food_id = $row3['food_id'];
                                    
                                    $qty = $row3['qty'];


                                    //getting food price from food id
                                    $sql4 = "SELECT * FROM tbl_food where food_id = $food_id ";
                                    //Execute Query
                                    $res4 = mysqli_query($conn, $sql4);
                                    $row4=mysqli_fetch_assoc($res4);
                                    $price = $row4['price'];
                                    $food= $row4['title'];



                                ?>



                                    <tr>
                                        <td><?php echo $order_id; ?></td>
                                        <td><?php echo $food; ?></td>
                                        <td><?php echo $price; ?></td>
                                        <td><?php echo $qty; ?></td>
                                        <td><?php echo $total; ?></td>
                                        <td><?php echo $order_date; ?></td>

                                        <td>
                                            <?php 
                                                // Ordered, On Delivery, Delivered, Cancelled

                                                if($status=="Ordered")
                                                {
                                                    echo "<label>$status</label>";
                                                }
                                                elseif($status=="On Delivery")
                                                {
                                                    echo "<label style='color: orange;'>$status</label>";
                                                }
                                                elseif($status=="Delivered")
                                                {
                                                    echo "<label style='color: green;'>$status</label>";
                                                }
                                                elseif($status=="Cancelled")
                                                {
                                                    echo "<label style='color: red;'>$status</label>";
                                                }
                                            ?>
                                        </td>

                                        <td><?php echo $customer_name; ?></td>
                                        <td><?php echo $customer_contact; ?></td>
                                        <td><?php echo $customer_email; ?></td>
                                        <td><?php echo $customer_street_address; ?></td>
                                        <td><?php echo $customer_pincode; ?></td>
                                        <td>
                                            <a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $order_id; ?>" class="btn-secondary">Update Order</a>
                                        </td>
                                    </tr>

                                <?php

                            }
                        }
                        else
                        {
                            //Order not Available
                            echo "<tr><td colspan='14' class='error'>Orders not Available</td></tr>";
                        }
                    ?>

 
                </table>
    </div>
    
</div>

<?php include('partials/footer.php'); ?>