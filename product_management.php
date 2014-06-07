<?php

  require_once 'lib/models/product.php';
  require_once 'lib/view_components.php';
  
  // start session
  session_start();
  
  $path = '';
  if (isset($_POST['type']) && isset($_SESSION['staff_user'])) {
    $type = $_POST['type'];
  
    // add a new product
    if ($type = 'add') {
      $name = $_POST['name'];
      $category = $_POST['category'];
      $brand = $_POST['brand'];
      $price = round(floatval($_POST['price']), 2);
      $img = $_POST['imagelink'];
      $des = $_POST['description'];
      
      try {
        if (Product::add_product_to_db($name, $category, $brand, $price, $img, $des)) {
          gen_html_redirect_header($path, 'index.php', '4');
          require 'views/simple_navbar.php';

          $msg = 'If you are not redirected to the home page, please click '
                  . '<a href="views/home.php">here</a>.';
          gen_simple_context('Product adding successful', $msg);
          require 'views/html_footer.php';
        } else {
          gen_html_redirect_header($path, 'add_product.php', '4');
          require 'views/simple_navbar.php';

          $msg = 'Please check the product details and try is later again';
          gen_simple_context('Oops, adding failed', $msg);

          require 'views/html_footer.php';
          exit;
        }
      } catch (Exception $e) {
        gen_html_redirect_header($path, 'add_product.php', '4');
        require 'views/simple_navbar.php';
        $err_msg = $e->getMessage();
        $msg = 'Error code: ' . $err_msg . ' <br> ';
        gen_simple_context('Oops, adding failed', $msg);
        require 'views/html_footer.php';
        exit;
      }
    }
    
    
  } else {
    
  }
  

  
?>


