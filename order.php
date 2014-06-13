<?php

  require_once 'lib/view_components.php';
  require_once 'lib/models/user.php';
  require_once 'lib/models/order.php';
  
  // used for input checking
  function form_prechecking($path, $user_id, $user_name, $flight_no, 
                            $flight_date, $flight_seat, $requirement) {
    
    $order = new Order();
    $order->set_userid($user_id);
    $order->set_user_name($user_name);
    $order->set_flight_no($flight_no);
    $order->set_flight_date($flight_date);
    $order->set_flight_seat($flight_seat);
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
  
  if (isset($_SESSION['valid_user']) && isset($_POST['type'])) {
    $type = $_POST['type'];
    
    try { // in case that any unknown error happens (e.g. db error)
      
      if ($type == 'add') {
        $user_id = $_SESSION['valid_user'];
        $user_name = $_POST['username'];
        $flight_no = $_POST['flightno'];
        $flight_date = $_POST['flightdate'];
        $flight_seat = $_POST['flightseat'];
        $requirement = $_POST['requirement'];
        $order = form_prechecking($path, $user_id, $user_name, $flight_no, 
                            $flight_date, $flight_seat, $requirement);

        // make order in db
        $order_id = $order->insert_to_db();
        if (!$order_id) {
          require 'views/html_header.php';
          require 'views/navbar.php';
          require 'views/order_form.php';
          require 'views/html_footer.php';
          exit;
        }

        // this address may be changed later
        $msg = 'Redirect to homepage';
        redirect_page($path, 'index.php', '4', $msg, 'Operation successful');
      } elseif ($type == 'cancel') {
        header('Location: index.php');
      }
      
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
