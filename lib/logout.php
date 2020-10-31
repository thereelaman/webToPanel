<?php
   session_start();
    //unset($_SESSION['username']);
    $_SESSION['logged_in'] = false;
    //echo 'You have been logged out. ';
    session_destroy();
    header("location: ../../index.php");
    
?>