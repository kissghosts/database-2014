<?php

  require_once 'lib/models/product.php';
  require_once 'lib/view_components.php';
  
  // used for adding and editing product
  function form_prechecking($id, $name, $category, $brand, $price, $img, $des, $path) {
    $product = new Product();
    
    if ($id != '') {
      $product->set_id($id);
    }
    $product->set_name($name);
    $product->set_brand($brand);
    $product->set_category($category);
    $product->set_price($price);
    $product->set_image_info($img);
    $product->set_description($des);

    if ($product->contains_error_attribute()) { // illegal input
      
      if ($id != '') {
        $type = 'edit';   // edit operation
        $title = 'Edit product';
        $button = 'Edit';
      } else {
        $type = 'add';   // add operation
        $title = 'Add product';
        $button = 'Add';
      }

      require 'views/html_header.php';
      require 'views/simple_navbar.php';
      require 'views/add_product_form.php';
      require 'views/html_footer.php';
      
      exit;
    }

    // check whether same product exits
    if ($id != '') {
      $p = Product::get_product_by_id($id);
      if (!$p) { // no product found
        $msg = 'Error product id!';
        redirect_page($path, 'index.php', '4', $msg, 'Editing failed');
        exit;
      }
    } else {
      $p = Product::get_product_by_name_and_category($name, $category);
      if ($p) { // same product found
        $msg = 'Same product found!';
        redirect_page($path, 'index.php', '4', $msg, 'Adding failed');
        exit;
      }
    }
    
    return $product;
  }
  
  
  // start session
  session_start();
  
  $path = '';
  if (isset($_POST['type']) && isset($_SESSION['staff_user'])) {
    $type = $_POST['type'];
  
    try {

      // add a new product
      if ($type == 'add') {

        $product = form_prechecking('', htmlspecialchars($_POST['name']), 
                                    htmlspecialchars($_POST['category']), 
                                    htmlspecialchars($_POST['brand']), 
                                    round(floatval($_POST['price']), 2),
                                    htmlspecialchars($_POST['imagelink']),
                                    htmlspecialchars($_POST['description']), $path);

        // if OK, try to add it
        $id = $product->insert_to_db();
        if (!$id) { // db operation failed
          $title = 'Oops, adding failed';
          $msg = 'Database operation failed. Please try it later again';
          redirect_page($path, 'product_form.php', '4', $msg, $title);
          exit;
        } else {
          $msg = 'If you are not redirected to the home page, please click '
                  . '<a href="index.php">here</a>.';
          $title = 'Product adding successful';
          redirect_page($path, 'index.php', '4', $msg, $title);
          exit;
        }

      } elseif ($type == 'edit' && isset($_POST['id'])) {
        $product = form_prechecking($_POST['id'], 
                                    htmlspecialchars($_POST['name']), 
                                    htmlspecialchars($_POST['category']), 
                                    htmlspecialchars($_POST['brand']), 
                                    round(floatval($_POST['price']), 2),
                                    htmlspecialchars($_POST['imagelink']),
                                    htmlspecialchars($_POST['description']), $path);

        if ($product->update_in_db()) {
          $msg = 'If you are not redirected to the home page, please click '
                  . '<a href="index.php">here</a>.';
          redirect_page($path, 'index.php', '4', $msg, 'Product editing successful');
          exit;
        } else {
          $msg = 'Database operation failed. Please try it later again';
          redirect_page($path, 'index.php', '4', $msg, 'Oops, editing failed');
          exit;
        }

      } elseif ($type == 'delete' && isset($_POST['id'])) {
        $id = $_POST['id'];
        $p = Product::get_product_by_id($id);
        if (!$p) { // no product found
          $msg = 'Error product id!';
          redirect_page($path, 'index.php', '4', $msg, 'Oops, deleting failed');
          exit;
        }
        
        if (Product::delete_product_by_id($id)) {
          $msg = 'If you are not redirected to the home page, please click '
                  . '<a href="index.php">here</a>.';
          redirect_page($path, 'index.php', '4', $msg, 'Deleting successful');
          exit;
        } else {
          $msg = 'Database operation failed.';
          redirect_page($path, 'index.php', '4', $msg, 'Deleting failed');
          exit;
        }
      }
    
    } catch (Exception $e) {
      $msg = $e->getMessage();
      redirect_page($path, 'index.php', '4', $msg, 'Operation failed');
      exit;
    }
    
  } else {
    $msg = 'You can not perform this operation';
    redirect_page($path, 'index.php', '4', $msg, 'Operation failed');
    exit;
  }
  
  

  
?>


