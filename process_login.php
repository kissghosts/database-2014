<?php

  require_once('lib/user_auth.php');
  require_once('lib/view_components.php');
  
  session_start();
  $email = $_POST['email'];
  $passwd = $_POST['p'];
  
  if ($email && $passwd) {
    // they have just tried logging in
    try {
      login($email, $passwd);
      // if they are in the database register the user id
      $_SESSION['valid_user'] = $email;
      
      header('location: views/home.php');
      
    } catch(Exception $e) {
      // unsuccessful login
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
    <meta http-equiv="refresh" content="3; url=views/login.php">
    <link rel="shortcut icon" href="ico/favicon.ico">
    <title>Shopping Cart</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
  </head>
  <body>
    
<?php

      gen_simple_navbar('');
      $err_msg = $e->getMessage();
      $msg = 'Error code: ' . $err_msg . ' <br> ';
      gen_simple_context('You could not be logged in.', $msg);
      gen_footer('');
      exit;
    }
  }
?>


