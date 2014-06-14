<?php
  // home page for the shopping cart
  require_once 'lib/db.php';
  require_once 'lib/models/product.php';
  require_once 'lib/view_components.php';

  function init_product_from_fetch_object($obj) {
    $product = new Product();

    $product->set_id($obj->product_id);
    $product->set_name($obj->name);
    $product->set_category($obj->category);
    $product->set_brand($obj->brand);
    $product->set_price($obj->price);
    $product->set_image_info($obj->imgurl);
    $product->set_description($obj->description);

    return $product;
  }

  session_start();

  // $path is used for all the view templates
  $path = '';
  $limit = 9;
  $offset = 0;
  $currnt_page = 0;  // start page number is 0 (the first index page)
  $category = '';
  $products = array();

  try { // in case of unknown database error
    $categories = Product::get_all_categories();

    if (isset($_GET['page'])) {
      $page = (int)$_GET['page'];
      $current_page = $page;
      if ($page >= 1) {
        $offset = $page * $limit; 
      }
    }

    if (isset($_POST['search'])) {
      $search_keyword = $_POST['search'];
      $product_total_num = Product::get_product_num_by_search($search_keyword);

      foreach(Product::search_products($search_keyword, $limit, $offset) as $p) {
        $product = init_product_from_fetch_object($p);
        $products[] = $product;
      }
    } elseif (isset($_GET['category'])) {
      $category = $_GET['category'];
      $product_total_num = Product::get_product_num_by_category($category);

      foreach(Product::get_products_by_category($category, $limit, $offset) as $p) {
        $product = init_product_from_fetch_object($p);
        $products[] = $product;
      }
    } else { // all products
      $product_total_num = Product::get_product_num();

      foreach(Product::get_products($limit, $offset) as $p) {
        $product = init_product_from_fetch_object($p);
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
  } catch (Exception $ex) {
    $msg = 'Error: ' . $ex->getMessage();
    redirect_page($path, 'info.html', '4', $msg, 'Internal Error!');
    exit;
  }
  

?>
