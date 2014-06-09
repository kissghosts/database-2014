<?php
  // home page for the shopping cart
  require_once 'lib/db.php';
  require_once 'lib/models/product.php';

  session_start();
  
  // $path is used for all the view templates
  $path = '';
  $limit = 9;
  $offset = 0;
  $currnt_page = 0;  // start page number is 0 (the first index page)
  $category = '';
  $products = array();
  
  $categories = Product::get_all_categories();
  
  if (isset($_GET['page'])) {
    $page = (int)$_GET['page'];
    $current_page = page;
    if ($page >= 1) {
      $offset = $page * $limit; 
    }
  }
  
  if (isset($_GET['category'])) {
    $category = $_GET['category'];
    $product_total_num = Product::get_product_num_by_category($category);
    
    
    foreach(Product::get_products_by_category($category, $limit, $offset) as $p) {
      $product = new Product();
      $product->set_id($p->product_id);
      $product->set_name($p->name);
      $product->set_category($p->category);
      $product->set_brand($p->brand);
      $product->set_price($p->price);
      $product->set_image_info($p->imgurl);
      $product->set_description($p->description);
      
      $products[] = $product;
    }
    
    
  } else { // all products
    $product_total_num = Product::get_product_num();
    
    foreach(Product::get_products($limit, $offset) as $p) {
      $product = new Product();
      $product->set_id($p->product_id);
      $product->set_name($p->name);
      $product->set_category($p->category);
      $product->set_brand($p->brand);
      $product->set_price($p->price);
      $product->set_image_info($p->imgurl);
      $product->set_description($p->description);
      
      $products[] = $product;
    }
  }
  
  $total_page_num = ceil($product_total_num/$limit);
  
  
  // html view
  require 'views/html_header.php';
  require 'views/navbar.php';
  require 'views/main_body_start.php';
  require 'views/sidebar.php';
  require 'views/product_list.php';
  require 'views/main_body_end.php';
  require 'views/html_footer_with_form_hash.php';

?>
