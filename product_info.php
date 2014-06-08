<?php
  require_once 'lib/db.php';
  require_once 'lib/models/product.php';
  require_once 'lib/view_components.php';

  session_start();
  $path = '';
  
  if (isset($_GET['id'])) {
    $id = $_GET['id'];
  } else {
    gen_html_redirect_header($path, 'index.php', '4');
    require 'views/simple_navbar.php';
    
    $msg = 'Error: no product id is given <br> Redirect back to homepage!';
    gen_simple_context('Oops, illegal query!!!', $msg);
    require 'views/html_footer.php';
    exit;
  }
  
  $categories = Product::get_all_categories();
  try {
    $p = Product::get_product_by_id($id);
  } catch (Exception $ex) {
    gen_html_redirect_header($path, 'index.php', '4');
    require 'views/simple_navbar.php';

    $msg = 'Error: illegal server query <br> Redirect back to homepage!';
    gen_simple_context('Oops, illegal query!!!', $msg);
    require 'views/html_footer.php';
    exit;
  }
  
  if (!$p) {
    gen_html_redirect_header($path, 'index.php', '4');
    require 'views/simple_navbar.php';

    $msg = 'Error: no such product found in server <br> Redirect back to homepage!';
    gen_simple_context('Oops, illegal query!!!', $msg);
    require 'views/html_footer.php';
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


