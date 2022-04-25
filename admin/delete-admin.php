<?php
    include('../config/constants.php');
    //getting the id of admin to delete
    $id = $_GET['id'];

    //sql query to delete the admin using id

    $sql= "DELETE FROM tbl_admin WHERE id=$id";

    //executing sql query
    $res= mysqli_query($conn, $sql);

    //check query success
    if($res==TRUE)
    {
        $_SESSION['delete']="<div class='success'>Admin Deleted successfully.</div>";
        //redirecting to admin page
        header("location:".SITEURL.'admin/manage-admin.php');
    }
    else
    {
        $_SESSION['delete']="<div class='error'>Failed to Delete Admin,</div>";
        //redirecting to admin page
        header("location:".SITEURL.'admin/manage-admin.php');
    }

?>