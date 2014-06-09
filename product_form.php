<?php
  
  require_once 'lib/view_components.php';
  require_once 'lib/models/product.php';

  session_start();
  $path = '';
  $product = new Product();
  $type = 'add';   // default operation
  $title = 'Add new product';
  $button = 'Add';
  
  if (isset($_GET['id'])) { // obtain product info for edit form
    $id = $_GET['id'];
    try {
      $p = Product::get_product_by_id($id);
    } catch (Exception $ex) {
      $msg = 'Error: illegal server query <br> Redirect back to homepage!';
      redirect_page($path, 'index.php', '4', $msg, 'Illegal query!!!');
      exit;
    }

    if (!$p) {
      $msg = 'Error: no such product found in server <br> Redirect back to homepage!';
      redirect_page($path, 'index.php', '4', $msg, 'Illegal query!!!');
      exit;
    }
    
    $type = 'edit';   // edit operation
    $title = 'Edit product';
    $button = 'Edit';
    $product->set_id($id);
    $product->set_name($p->name);
    $product->set_category($p->category);
    $product->set_brand($p->brand);
    $product->set_price($p->price);
    $product->set_image_info($p->imgurl);
    $product->set_description($p->description);
  }
  
  require 'views/html_header.php';
  require 'views/simple_navbar.php';
  require 'views/add_product_form.php';
  require 'views/html_footer.php';

?>

