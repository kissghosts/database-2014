<?php

  session_start();
  $old_user = $_SESSION['valid_user'];
  
  // store to test if they *were* logged in
  unset($_SESSION['valid_user']);
  $result_dest = session_destroy();
  header('location: index.php');
  
?>


