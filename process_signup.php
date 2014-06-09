<?php

  require_once 'lib/models/user.php';
  require_once 'lib/view_components.php';

  $email = $_POST['email'];
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $passwd = $_POST['p'];
  
  // start session
  session_start();
  
  $path = '';
  // currently only customer user could be registered
  $title = 'customer';
  
  try {
    // attempt to register a customer
    // this function can also throw an exception
    if (User::is_user_existed_in_db($email)) {
      throw new Exception('Your given email has been registered');
    }
    $id = User::register_user_in_db($email, $passwd, $fname, $lname, $title);
    
    // register session variable
    if ($title == 'customer') {
      $_SESSION['valid_user'] = $id;
    } else if ($title == 'staff') {
      $_SESSION['staff_user'] = $id;
    }

    $msg = 'If you are not redirected to the home page, please click '
            . '<a href="views/home.php">here</a>.';
    redirect_page($path, 'index.php', '4', $msg, 'Registration successful!');
    exit;

  } catch (Exception $e) {
    $msg = 'Error: ' . $e->getMessage();
    require 'views/html_header.php';
    require 'views/simple_navbar.php';
    html_alert_info('Sign-up failed: ', $msg . '<br>');
    require 'views/signup_form.php';
    require 'views/html_footer_with_form_hash.php';
  }
?>

