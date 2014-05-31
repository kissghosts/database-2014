<?php
  // home page for the shopping cart

  // require_once('../lib/view_components.php');

  session_start();
  
  // $path is used for all the view templates
  $path = '';
  
  require 'views/html_header.php';
  require 'views/navbar.php';
  require 'views/main_body.php';
  require 'views/html_footer_with_form_hash.php';

?>
