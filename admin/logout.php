<?php

    include('../config/constants.php');
    //end session
    session_destroy();

    //redirecting to login page
    header('location:'.SITEURL.'admin/login.php');

?>