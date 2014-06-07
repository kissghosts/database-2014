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
    User::register_user_in_db($email, $passwd, $fname, $lname, $title);
    
    // register session variable
    if ($title == 'customer') {
      $_SESSION['valid_user'] = $email;
    } else if ($title == 'staff') {
      $_SESSION['staff_user'] = $email;
    }
    
    gen_html_redirect_header($path, 'index.php', '4');
    require 'views/simple_navbar.php';
    
    $msg = 'If you are not redirected to the home page, please click '
            . '<a href="views/home.php">here</a>.';
    gen_simple_context('Congratulations, registration successful', $msg);
    require 'views/html_footer.php';

  } catch (Exception $e) {
    gen_html_redirect_header($path, 'signup.php', '4');
    require 'views/simple_navbar.php';
    
    $err_msg = $e->getMessage();
    $msg = 'Error code: ' . $err_msg . ' <br> ';
    gen_simple_context('Oops, registration failed', $msg);
    
    require 'views/html_footer.php';
    exit;
  }
?>

