<?php
  
  /**
  * controller for logout, delete session variable
  *
  * @author yfliu
  */

  session_start();
  
  if (isset($_SESSION['valid_user'])) {
    unset($_SESSION['valid_user']);
  }
  
  if (isset($_SESSION['staff_user'])) {
    unset($_SESSION['staff_user']);
  }
  
  $result_dest = session_destroy();
  header('location: index.php');
  
?>


