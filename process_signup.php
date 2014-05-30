<?php

  require_once 'lib/user_auth.php';
  require_once 'lib/view_components.php';

  $email = $_POST['email'];
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $passwd = $_POST['p'];
  
  // start session
  session_start();
?>

<!-- // the following html header includes refresh meta -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta http-equiv="refresh" content="3; url=views/home.php">
    <link rel="shortcut icon" href="ico/favicon.ico">
    <title>Shopping Cart</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
  </head>
  <body>

<?php
  try {
    // attempt to register
    // this function can also throw an exception
    register($email, $passwd, $fname, $lname);
    // register session variable
    $_SESSION['valid_user'] = $email;
    
    gen_simple_navbar('');
    $msg = 'If you are not redirected to the home page, please click '
            . '<a href="views/home.php">here</a>.';
    gen_simple_context('Congratulations, registration successful', $msg);
    gen_footer('');

  } catch (Exception $e) {
    gen_simple_navbar('');
    
    $err_msg = $e->getMessage();
    $msg = 'Error code: ' . $err_msg . ' <br> ';
    gen_simple_context('Oops, registration failed', $msg);
    
    gen_footer('');
    exit;
  }
?>

