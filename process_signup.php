<?php

  require_once 'lib/user_auth.php';
  require_once 'lib/view_components.php';

  $email = $_POST['email'];
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $passwd = $_POST['p'];
  
  // start session
  session_start();
  
  $path = '';
  
  try {
    // attempt to register
    // this function can also throw an exception
    register($email, $passwd, $fname, $lname);
    // register session variable
    $_SESSION['valid_user'] = $email;
    
    gen_html_redirect_header('Shopping Cart', $path, 'index.php', '4');
    require 'views/simple_navbar.php';
    
    $msg = 'If you are not redirected to the home page, please click '
            . '<a href="views/home.php">here</a>.';
    gen_simple_context('Congratulations, registration successful', $msg);
    require 'views/html_header.php';

  } catch (Exception $e) {
    gen_html_redirect_header('Shopping Cart', $path, 'signup.php', '4');
    require 'views/simple_navbar.php';
    
    $err_msg = $e->getMessage();
    $msg = 'Error code: ' . $err_msg . ' <br> ';
    gen_simple_context('Oops, registration failed', $msg);
    
    require 'views/html_header.php';
    exit;
  }
?>

