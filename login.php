<?php

  require_once 'lib/models/user.php';
  require_once('lib/view_components.php');
  
  session_start();
  $path = '';
  
  if (isset($_POST['email']) && isset($_POST['p'])) {
    $email = $_POST['email'];
    $passwd = $_POST['p'];

    if ($email && $passwd) {

      // check whether user exists in database
      if (!User::is_user_existed_in_db($email)) {
        require 'views/html_header.php';
        require 'views/simple_navbar.php';
        html_alert_info('Login failed: ', 'the email address is not registered <br>');
        gen_login_form('', $path);
        require 'views/html_footer_with_form_hash.php';

        exit;
      }

      $result = User::check_user($email, $passwd);
      if (!$result) {
        require 'views/html_header.php';
        require 'views/simple_navbar.php';
        html_alert_info('Login failed: ', 'wrong password <br>');
        gen_login_form($email, $path);
        require 'views/html_footer_with_form_hash.php';
        exit;
      } else if ($result == 'customer') {
        $_SESSION['valid_user'] = $email;
      } else if ($result == 'staff') {
        $_SESSION['staff_user'] = $email;
      }

      header('location: index.php');
    }
  } else {
    require 'views/html_header.php';
    require 'views/simple_navbar.php';
    gen_login_form('', $path);
    require 'views/html_footer_with_form_hash.php';
  }
?>


