<?php

  require_once 'lib/view_components.php';
  require_once 'lib/models/user.php';
  require_once 'lib/models/order.php';
  
  // used for input checking
  function form_prechecking($user_id, $user_name, $flight_no, $flight_date, 
      $flight_seat, $requirement) {
    
    $order = new Order();
    $order->set_userid($user_id);
    $order->set_user_name($user_name);
    $order->set_flight_no($flight_no);
    $order->set_flight_date($flight_date);
    $order->set_flight_seat($flight_seat);
    $order->set_status('processing');
    $order->set_requirement($requirement);
    
    if ($order->contains_error_attribute()) { // illegal input
      require 'views/html_header.php';
      require 'views/navbar.php';
      require 'views/order_form.php';
      require 'views/html_footer.php';
      exit;
    }
    
    return $order;
  }

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
      
      $flight_no = $_POST['flightno'];
      $flight_date = $_POST['flightdate'];
      $flight_seat = $_POST['flightseat'];
      $requirement = $_POST['requirement'];
      $order = form_prechecking($user_id, $user_name, $flight_no, 
                          $flight_date, $flight_seat, $requirement);
      
      // make order in db
      
      
    } catch (Exception $e) {
      $msg = $e->getMessage();
      redirect_page($path, 'index.php', '4', $msg, 'Operation failed');
    }
    
  } else {
    $msg = 'You can not perform this operation, redirect to '
           . '<a href="login.php">sign-in</a> page.';
    redirect_page($path, 'login.php', '4', $msg, 'Operation failed');
  }
  

  
  
?>