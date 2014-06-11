<?php

  require_once 'lib/models/cart_item.php';
  require_once 'lib/models/product.php';
  require_once 'lib/view_components.php';
  
  session_start();
  
  $path = '';
  $limit = 10;
  $offset = 0;
  $currnt_page = 0;  // start page number is 0 (the first index page)
  $products = array();
  $cart_items = array();
  
  if (isset($_SESSION['valid_user'])) {
    $user_id = $_SESSION['valid_user'];
    
    try {
      
      if (isset($_POST['type']) && $_POST['type'] == 'add') { // add to cart
        $product_id = $_POST['productid'];
        $cart_item = new CartItem();
        
        $item = CartItem::get_item_by_userid_and_productid($user_id, $product_id);
        if ($item) {
          $cart_item->set_item_id($item->cart_item_id);
          $cart_item->set_quantity(((int)$item->quantity) + 1);
          
          $cart_item->update_in_db();
        } else {
          $cart_item->set_user_id($user_id);
          $cart_item->set_product_id($product_id);
          $cart_item->set_quantity(1);
          $result = $cart_item->insert_to_db();
          if (empty($result)) {
            $msg = 'Fail to perform adding operation.';
            redirect_page($path, 'product_info.php&id=' . $product_id, '4', $msg, 'Adding failed');
          } else {
            $msg = 'Redirect to homepage :)';
            redirect_page($path, 'index.php', '3', $msg, 'Adding successfully');
          }
        }

      } else { // show shopping cart
        if (isset($_GET['page'])) {
          $page = (int)$_GET['page'];
          $current_page = page;
          if ($page >= 1) {
            $offset = $page * $limit; 
          }
        }
        
        $item_total_num = CartItem::get_item_num_by_userid($user_id);
        $total_page_num = ceil($item_total_num/$limit);

        foreach(CartItem::get_items_by_userid($user_id, $limit, $offset) as $i) {
          $item = new CartItem();
          $item->init_from_db_object($i);
          $cart_items[] = $item;
          
          $product = new Product();
          $p = Product::get_product_by_id($item->get_product_id());
          if (!$p) {
            $msg = 'Unknown product found in shopping cart.';
            redirect_page($path, 'index.php', '4', $msg, 'Unknown error!!!');
            exit;
          }
          $product->init_from_fetched_object($p);
          $products[] = $product;
        }

        // html view
        require 'views/html_header.php';
        require 'views/navbar.php';
        require 'views/shopping_cart_list.php';
        require 'views/html_footer.php';
        
      } 
      
    } catch (Exception $e) { // in case that some unknown error happens
      $msg = $e->getMessage();
      redirect_page($path, 'index.php', '4', $msg, 'Operation failed');
    }

  } else {
    $msg = 'You can not perform this operation, please first sign in.';
    redirect_page($path, 'login.php', '4', $msg, 'Operation failed');
  }

  
  
  
  
  
  
  
  
  
?>

