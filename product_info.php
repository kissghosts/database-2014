<?php
  
  /**
  * display product details
  *
  * @author yfliu
  */

  require_once 'lib/db.php';
  require_once 'lib/models/product.php';
  require_once 'lib/view_components.php';

  session_start();
  $path = '';
  
  if (isset($_GET['id'])) {
    $id = $_GET['id'];
  } else {
    $msg = 'Error: no product id is given <br> Redirect back to homepage!';
    redirect_page($path, 'index.php', '4', $msg, 'Illegal query!!!');
    exit;
  }
  try {
    $categories = Product::get_all_categories();
    
    $p = Product::get_product_by_id($id);
  } catch (Exception $ex) {
    $msg = 'Error: ' . $ex->getMessage();
    redirect_page($path, 'index.php', '4', $msg, 'Query Error!!!');
    exit;
  }
  
  if (!$p) {
    $msg = 'Error: no such product found in server <br> Redirect back to homepage!';
    redirect_page($path, 'index.php', '4', $msg, 'Illegal query!!!');
    exit;
  }
  
  $product = new Product();
  $product->set_id($id);
  $product->set_name($p->name);
  $product->set_category($p->category);
  $product->set_brand($p->brand);
  $product->set_price($p->price);
  $product->set_image_info($p->imgurl);
  $product->set_description($p->description);
  
  // html view
  require 'views/html_header.php';
  require 'views/navbar.php';
  require 'views/main_body_start.php';
  require 'views/sidebar.php';
  require 'views/product_detail.php';
  require 'views/main_body_end.php';
  require 'views/html_footer_with_form_hash.php';

?>


