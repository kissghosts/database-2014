<?php

  require_once('lib/db.php');
  require_once('lib/view_components.php');
  
  session_start();
  $path = '';
  
  if (isset($_POST['email']) && isset($_POST['p'])) {
    $email = $_POST['email'];
    $passwd = $_POST['p'];

    if ($email && $passwd) {

      // connect to db
      $conn = get_db_connection();
      // check whether email address exists in db
      $sql = "SELECT * from users where email = '".$email."'";
      $query = $conn->prepare($sql);
      $query->execute();
      $result = $query->fetch();

      if (!$result) {
        require 'views/html_header.php';
        require 'views/simple_navbar.php';
        html_alert_info('Login failed: ', 'the email address is not registered <br>');
        gen_login_form('', $path);
        require 'views/html_footer_with_form_hash.php';

        exit;
      }

      $sql = "SELECT * from users where email = '".$email."' and passwd = '"
              . $passwd . "'";
      $query = $conn->prepare($sql);
      $query->execute();

      $result = $query->fetch();

      if (!$result) {
        require 'views/html_header.php';
        require 'views/simple_navbar.php';
        html_alert_info('Login failed: ', 'wrong password <br>');
        gen_login_form($email, $path);
        require 'views/html_footer_with_form_hash.php';
        exit;
      }

      // if they are in the database register the user id
      $_SESSION['valid_user'] = $email;

      header('location: index.php');
    }
  } else {
    require 'views/html_header.php';
    require 'views/simple_navbar.php';
    gen_login_form('', $path);
    require 'views/html_footer_with_form_hash.php';
  }
?>


