<?php include('../config/constants.php'); ?>

<html>
    <head>
        <title>Login - Food Order System</title>
        <link rel="stylesheet" href="../css/admin.css">
        <style>
            body {
                height: 100%
            }

            body {
                display: grid;
                place-items: center;
                background-image: url("../images/login/food.jpg");
            }
            .login{
                display: grid;
                place-items: center;
                background: #ff4757;
                border-radius: 15px;
            }
            .logintext
            {
                font-size:400%;
                font-family: monospace;
                color: #fff;
            }
            .text-center
            {
                font-size:200%;
                font-family: monospace;
                color: #fff;
            }
            .btn-primary
            {
                    background-color: #1e90ff;
                    padding: 8%;
                    color: white;
                    text-decoration: none;
                    font-weight: bold;
                    border-radius: 15px;
            }
        </style>
    </head>

    <body>
        
        <div class="login">
            <h1 class="logintext" >Login</h1>
            <br><br>

            <?php 
                if(isset($_SESSION['login']))
                {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }

                if(isset($_SESSION['no-login-message']))
                {
                    echo $_SESSION['no-login-message'];
                    unset($_SESSION['no-login-message']);
                }
            ?>
            <br><br>

            <!-- Login Form Starts HEre -->
            <form action="" method="POST" class="text-center">
            Username: <br>
            <input type="text" name="username" placeholder="Enter Username"><br><br>

            Password: <br>
            <input type="password" name="password" placeholder="Enter Password"><br><br>

            <input type="submit" name="submit" value="Login" class="btn-primary">
            <br><br>
            </form>
            <!-- Login Form Ends HEre -->

            
        </div>

    </body>
</html>



<?php
//if submit button clicked
    if(isset($_POST['submit']))
    {   

        $username = mysqli_real_escape_string($conn, $_POST['username']);
        
        $raw_password = md5($_POST['password']);
        $password = mysqli_real_escape_string($conn, $raw_password);


        //getting admin details from the sql table
        $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

        //executing sql query
        $res= mysqli_query($conn, $sql);

        $count= mysqli_num_rows($res);
        

        //
        if($count==1)
        {   
            //getting admin id which is active
            $row=mysqli_fetch_assoc($res);
            $admin_id=$row['id'];

            //User AVailable and Login Success
            $_SESSION['login'] = "<div class='success'>Login Successful.</div>";
            //$_SESSION['user'] = $username; //TO check whether the user is logged in or not and logout will unset it
            $_SESSION['user'] = $admin_id; //TO check whether the user is logged in or not and logout will unset it

            //REdirect to Home Page/Dashboard
            header('location:'.SITEURL.'admin/');
        }
        else
        {
            //User not Available and Login FAil
            $_SESSION['login'] = "<div class='error text-center'>Username or Password did not match.</div>";
            //REdirect to HOme Page/Dashboard
            header('location:'.SITEURL.'admin/login.php');
        }


    }

?>