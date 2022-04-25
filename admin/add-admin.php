<?php include ('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
<h1>Add Admin</h1>
<br>

<?php
        if(isset($_SESSION['add']))
        {
            echo $_SESSION['add'];//Displaying session message
            unset($_SESSION['add']);
        }
     ?>
     <br><br>
     
<form action="" method="POST">
    <table class="tbl-30">
        <tr>
            <td>First Name</td>
            <td><input type="text" name="first_name" placeholder="Enter First Name"></td>
        </tr>
        <tr>
            <td>Last Name</td>
            <td><input type="text" name="last_name" placeholder="Enter Last Name"></td>
        </tr>
        <tr>
            <td>Username: </td>
            <td>
                <input type="text" name="username" placeholder="Your Username">
            </td>
        </tr>
        <tr>
            <td>Password: </td>
            <td>
                <input type="password" name="password" placeholder="Your Password">
            </td>
        </tr>
        <tr>
            <td colspan="2">
              <input type="submit" name="submit" value="Add Admin" class="btn-secondary">  
            </td>
        </tr>
    </table>
</form>
    </div>
</div>
<?php include ('partials/footer.php'); ?>

<?php

// if the form is submitted we get the data from the form and store it into variables
  if(isset($_POST['submit'])){
  //echo "Button Clicked";
 $first_name=$_POST["first_name"];
 $last_name=$_POST["last_name"];
 $username=$_POST["username"];
 $password=md5($_POST["password"]); //Password Encrypted with MD5
 
//sql query for Adding data to database
$sql="INSERT INTO tbl_admin SET 
   first_name='$first_name',
   last_name='$last_name',
   username='$username',
   password='$password'

";


//saving the data from the sql query into the database  
$res = mysqli_query($conn, $sql) or die(mysqli_error());

if($res==TRUE)
{
    //echo "data inserted";
    //session variable
    $_SESSION['add'] = "<div class='success'>Admin added successfully</div>";

    //redirecting to manage-admin page
    header("location:".SITEURL.'admin/manage-admin.php');
}
else 
{
    //echo "failed to insert data";
    //session variable
    $_SESSION['add'] = "<div class='success'>Failed to add Admin</div>";

    //redirecting to manage-admin page
    header("location:".SITEURL.'admin/add-admin.php');
}
}
 
?>