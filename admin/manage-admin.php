<?php include ('partials/menu.php'); ?>
    <div class="main-content"><div class="wrapper">
     <h1>Manage Admin</h1>
     <br>
     <br>

     <?php
        if(isset($_SESSION['add']))
        {
            echo $_SESSION['add'];//Displaying session message
            unset($_SESSION['add']);
        }
        if(isset($_SESSION['delete']))
        {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }
        if(isset($_SESSION['update']))
        {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }if(isset($_SESSION['change-pwd']))
        {
            echo $_SESSION['change-pwd'];
            unset($_SESSION['change-pwd']);
        }
     ?>
     <br><br>

      <a href="add-admin.php" class="btn-primary">Add Admin</a>
  <br>
  <br>
     <table class="tbl-full">
         <tr>
             <th>ID.No</th>
             <th>First Name</th>
             <th>Last Name</th> 
             <th>Username</th>
            <th>Actions</th>
         </tr>

         <?php
         //getting all data from tbl_admin through sql query
            $sql= "SELECT * FROM tbl_admin";
            //executing sql query
            $res= mysqli_query($conn, $sql);

            //checking if sql query executed succcessfully

            if($res==TRUE)
            {
                //checking the number of rows in the database
                $count = mysqli_num_rows($res);

                if($count>0)//if dataabse contains any data
                {
                    while($rows = mysqli_fetch_assoc($res))
                    {
                        //getting all rows from the database

                        $id=$rows['id'];
                        $first_name=$rows['first_name'];
                        $last_name=$rows['last_name'];
                        $username=$rows['username'];

                        //displaying these in the webpage table
                        ?>

                    <tr>
                        <td><?php echo $id ?></td>
                        <td><?php echo $first_name ?></td>
                        <td><?php echo $last_name ?></td>
                        <td><?php echo $username ?></td>
                        <td>
                        <a href="<?php echo SITEURL;?>admin/update-password.php?id=<?php echo $id?>" class="btn-primary">Update Password</a>
                        <a href="<?php echo SITEURL;?>admin/update-admin.php?id=<?php echo $id?>" class="btn-secondary">Update Admin</a>
                        <!-- <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">Delete Admin</a> -->
                        </td>
                    </tr>

                    <?php
                    }
                }
            }
         ?>
         
     </table>
      
      <div class="clearfix"></div>
      </div> </div>
          <?php include ('partials/footer.php'); ?>

    </body>
</html>