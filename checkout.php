<?php

  require_once 'lib/view_components.php';
  require_once 'lib/models/user.php';
  
  // start session
  session_start();
  $path = '';
  
  if (isset($_SESSION['valid_user'])) {
    
    try { // in case that any unknown error happens (e.g. db error)
      $user_id = $_SESSION['valid_user'];
      $u = User::get_user_by_userid($user_id);
      $user = new User();
      $user->init_from_db_object($u);
      
      $user_name = $user->get_fname() . ' ' . $user->get_lname();
      
      // show html order form
      require 'views/html_header.php';
      require 'views/navbar.php';
      require 'views/order_form.php';
      require 'views/html_footer.php';
      
    } catch (Exception $e) {
      $msg = $e->getMessage();
      redirect_page($path, 'shopping_cart.php', '4', $msg, 'Operation failed');
    }
    
  } else {
    $msg = 'You can not perform this operation, redirect to '
           . '<a href="login.php">sign-in</a> page.';
    redirect_page($path, 'login.php', '4', $msg, 'Operation failed');
  }
  
  
  
?>