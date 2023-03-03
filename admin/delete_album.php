<?php

  session_start();
   require_once '../config.php';
   include 'check_login.php';
  
    $id = $_GET['title_id'];

    //echo $id;

    $sql = "delete from album where id = '$id'";
    
    if (!$link) {
          die("Connection failed: " . mysqli_connect_error());
     }
    if (mysqli_query($link, $sql)) {
       $_SESSION['msg'] = '<div class="alert alert-success ">Deleted Successfully</div>';
       header("Location: profile.php");
     }
     else { 
         $_SESSION['msg'] = '<div class="alert alert-danger">Error Occurred!</div>';
         header("Location: profile.php");
     }
   
    mysqli_close($link);
?>


