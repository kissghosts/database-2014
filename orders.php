<?php
  
  /**
  * controller for orders
  * handling for the stuff for orders
  * add, delete, edit, and view
  *
  * @author yfliu
  */


  require_once 'lib/view_components.php';
  require_once 'lib/models/user.php';
  require_once 'lib/models/order.php';
  require_once 'lib/models/product.php';
  require_once 'lib/models/cart_item.php';
  require_once 'lib/models/order_item.php';
  require_once 'lib/models/notification.php';
  
  // used for input checking
  function form_prechecking($path, $user_id, $user_name, $flight_no, 
                            $flight_date, $flight_seat, $requirement) {
    
    $order = new Order();
    $order->set_userid($user_id);
    $order->set_user_name($user_name);
    $order->set_flight_no($flight_no);
    $order->set_flight_date($flight_date);
    $order->set_flight_seat($flight_seat);
    $order->set_requirement($requirement);
    
    if ($order->contains_error_attribute()) { // illegal input
      require 'views/html_header.php';
      require 'views/navbar.php';
      require 'views/order_form.php';
      require 'views/html_footer.php';
      exit;
    }
    
    return $order;
  }
  
  // show order list
  function show_customer_order_list($user_id, $path) {
    $limit = 10;
    $offset = 0;
    $currnt_page = 0;  // start page number is 0 (the first index page)
    $orders = array();

    if (isset($_GET['page'])) {
      $page = (int)$_GET['page'];
      $current_page = $page;
      if ($page >= 1) {
        $offset = $page * $limit; 
      }
    }

    $order_total_num = Order::get_order_num_by_userid($user_id);
    $total_page_num = ceil($order_total_num/$limit);

    foreach(Order::get_orders_by_userid($user_id, $limit, $offset) as $o) {
      $order = new Order();
      $order->init_from_db_object($o);
      $orders[] = $order;
    }

    // html view
    require 'views/html_header.php';
    require 'views/navbar.php';
    require 'views/order_list.php';
    require 'views/html_footer_with_form_hash.php';
  }
  
  // show all orders for staff
  function show_order_list($path) {
    $limit = 10;
    $offset = 0;
    $currnt_page = 0;  // start page number is 0 (the first index page)
    $orders = array();

    if (isset($_GET['page'])) {
      $page = (int)$_GET['page'];
      $current_page = $page;
      if ($page >= 1) {
        $offset = $page * $limit; 
      }
    }

    $order_total_num = Order::get_unconfirmed_order_num();
    $total_page_num = ceil($order_total_num/$limit);

    foreach(Order::get_unconfirmed_orders($limit, $offset) as $o) {
      $order = new Order();
      $order->init_from_db_object($o);
      $orders[] = $order;
    }

    // html view
    require 'views/html_header.php';
    require 'views/navbar.php';
    require 'views/order_list.php';
    require 'views/html_footer_with_form_hash.php';
  }
  
  // show order details
  function show_order_detail($order_id, $path) {

    $order_obj = Order::get_order_by_orderid($order_id);
    if (!$order_obj) {
      $msg = 'On corresponding order found.';
      redirect_page($path, 'orders.php', '4', $msg, 'Illegal request');
      exit;
    }
    $order = new Order();
    $order->init_from_db_object($order_obj);
    $order_items = array();
    $products = array();

    // store order_item and product into two array
    foreach (OrderItem::get_all_items_by_orderid($order_id) as $obj) {
      $order_item = new OrderItem();
      $order_item->init_from_db_object($obj);
      $order_items[] = $order_item;

      $product = new Product();
      $p = Product::get_product_by_id($order_item->get_product_id());
      if (!$p) {
        $msg = 'Unknown product found.';
        redirect_page($path, 'orders.php', '4', $msg, 'Unknown error!!!');
        exit;
      }
      $product->init_from_fetched_object($p);
      $products[] = $product;
    }

    require 'views/html_header.php';
    require 'views/navbar.php';
    require 'views/order_detail.php';
    require 'views/html_footer.php';
  }
  
  // delete order
  function delete_order($order_id, $path) {
    
    $order_obj = Order::get_order_by_orderid($order_id);
    if (!$order_obj) {
      $msg = 'No corresponding order found.';
      redirect_page($path, 'orders.php', '4', $msg, 'Illegal request');
      exit;
    }

    // delete order_item first
    $result = OrderItem::delete_items_by_orderid($order_id);
    if (!$result) {
      $msg = 'Can not delete order items in table order_items';
      redirect_page($path, 'orders.php', '4', $msg, 'Operation failed');
      exit;
    }

    $result = Order::delete_order_by_orderid($order_id);
    if (!$result) {
      $msg = 'Could not delete the item now';
      redirect_page($path, 'orders.php', '4', $msg, 'Unknown error');
      exit;
    }
    header('Location: orders.php');
  }
  
  // TODO: now all the logic conditions are put together, which might be 
  // a bit confusing, and difficult to modify
  // consider to separate this file later
  
  // start session
  session_start();
  $path = '';
  
  try { // in case that any unknown error happens (e.g. db error)
    
    if (isset($_SESSION['valid_user'])) {
      $user_id = $_SESSION['valid_user'];
      
      // add new order
      if (isset($_POST['type']) && $_POST['type'] == 'add') {    
        $user_name = $_POST['username'];
        $flight_no = $_POST['flightno'];
        $flight_date = $_POST['flightdate'];
        $flight_seat = $_POST['flightseat'];
        $requirement = $_POST['requirement'];
        $order = form_prechecking($path, $user_id, $user_name, $flight_no, 
                            $flight_date, $flight_seat, $requirement);

        // make order in db
        $result = $order->insert_to_db();
        if (!$result) {
          require 'views/html_header.php';
          require 'views/navbar.php';
          require 'views/order_form.php';
          require 'views/html_footer.php';
          exit;
        }
        $order_id = $order->get_orderid();
        
        // move item from table cart_items to order_items
        foreach (CartItem::get_all_items_by_userid($user_id) as $c_item) {
          $item = new OrderItem();
          $item->init_attributes($order_id, $c_item->product_id, $c_item->quantity);
          
          $result = $item->insert_to_db();
          if (!$result) {
            $msg = 'Can not init order_item in database';
            redirect_page($path, 'index.php', '4', $msg, 'Operation failed');
            exit;
          }
          $item->set_item_id($result);
          // $order_items[] = $item;
          
          $result = CartItem::delete_item_by_id($c_item->cart_item_id);
          if (!$result) {
            $msg = 'Can not delete cart_item from database.';
            redirect_page($path, 'index.php', '4', $msg, 'Database error!!!');
            exit;
          }
        }
      } elseif (isset($_POST['type']) && $_POST['type'] == 'cancel') {
        
        header('Location: index.php');
        exit;
      
      } elseif (isset($_POST['type']) && $_POST['type'] == 'delete') {
        // delete one order
        if (!isset($_POST['orderid'])) {
          $msg = 'Missing order id to continue operation.';
          redirect_page($path, 'orders.php', '4', $msg, 'Illegal request');
          exit;
        }
        $order_id = $_POST['orderid'];
        
        delete_order($order_id, $path);
        exit;
        
      } elseif (isset($_POST['type']) && $_POST['type'] == 'view') {
        // view details
        if (!isset($_POST['orderid'])) {
          $msg = 'Missing order id to continue operation.';
          redirect_page($path, 'orders.php', '4', $msg, 'Illegal request');
          exit;
        }
        $order_id = $_POST['orderid'];
        
        show_order_detail($order_id, $path);
        exit;
        
      } elseif (isset($_POST['type']) && $_POST['type'] == 'update') { 
        // update order item quantity
        
        if (!isset($_POST['orderid'])) {
          $msg = 'Missing order id to continue operation.';
          redirect_page($path, 'orders.php', '4', $msg, 'Illegal request');
          exit;
        }
        $order_id = $_POST['orderid'];
        
        $obj = Order::get_order_by_orderid($order_id);
        if ($obj->status != 'processing') {
          $msg = 'Confirmed order could not be changed anymore.';
          redirect_page($path, 'orders.php', '4', $msg, 'Illegal request');
          exit;
        }

        // change quantity
        if (!isset($_POST['itemid']) || !isset($_POST['quantity'])) {
          $msg = 'Missing item id to perform this operation!';
          redirect_page($path, 'orders.php', '4', $msg, 'Illegal Request!');
          exit;
        }
        
        $item_id = $_POST['itemid'];
        $quantity = $_POST['quantity'];
        if (OrderItem::update_quantity_by_itemid($item_id, $quantity)) {
          show_order_detail($order_id, $path);
        } else {
          $msg = 'Can not update item quantity right now!';
          redirect_page($path, 'orders.php', '4', $msg, 'Updating Failed!');
        }
        
        exit;
      
      } elseif (isset($_POST['type']) && $_POST['type'] == 'edit_form') {
        // generate order edit form
        
        if (!isset($_POST['orderid'])) {
          $msg = 'Missing order id to continue operation.';
          redirect_page($path, 'orders.php', '4', $msg, 'Illegal request');
          exit;
        }
        $order_id = $_POST['orderid'];
        
        $obj = Order::get_order_by_orderid($order_id);
        
        if (!$obj) {
          $msg = 'Not found this order id in database';
          redirect_page($path, 'orders.php', '4', $msg, 'Illegal request');
          exit;
        }
        if ($obj->status != 'processing') {
          $msg = 'Confirmed order could not be changed anymore.';
          redirect_page($path, 'orders.php', '4', $msg, 'Illegal request');
          exit;
        }
        
        $order = new Order();
        $order->init_from_db_object($obj);
        $type = 'edit';
        
        // show html order form
        require 'views/html_header.php';
        require 'views/navbar.php';
        require 'views/order_form.php';
        require 'views/html_footer.php';
        exit;
      } elseif (isset($_POST['type']) && $_POST['type'] == 'edit') {
        // edit order details
        
        if (!isset($_POST['orderid'])) {
          $msg = 'Missing order id to continue operation.';
          redirect_page($path, 'orders.php', '4', $msg, 'Illegal request');
          exit;
        }
        $order_id = $_POST['orderid'];
        
        $obj = Order::get_order_by_orderid($order_id);
        
        if (!$obj) {
          $msg = 'Not found this order id in database';
          redirect_page($path, 'orders.php', '4', $msg, 'Illegal request');
          exit;
        }
        if ($obj->status != 'processing') {
          $msg = 'Confirmed order could not be changed anymore.';
          redirect_page($path, 'orders.php', '4', $msg, 'Illegal request');
          exit;
        }
        
        $user_name = $_POST['username'];
        $flight_no = $_POST['flightno'];
        $flight_date = $_POST['flightdate'];
        $flight_seat = $_POST['flightseat'];
        $requirement = $_POST['requirement'];
        $order = form_prechecking($path, $user_id, $user_name, $flight_no, 
                            $flight_date, $flight_seat, $requirement);
        
        $order->set_booking_date($obj->booking_date);
        $order->set_status($obj->status);
        $order->set_orderid($obj->order_id);
        
        if (!($order->update_in_db())) {
          $msg = 'Can not update order info this time';
          redirect_page($path, 'orders.php', '4', $msg, 'Unknown error!!!');
          exit;
        }
        
        show_order_detail($order_id, $path);
        exit;
      }
      
      // show order list
      show_customer_order_list($user_id, $path);
      exit;
      
    } elseif (isset($_SESSION['staff_user'])) { // flight company staff
      if (isset($_POST['type']) && $_POST['type'] == 'delete') {
        // delete one order
        if (!isset($_POST['orderid'])) {
          $msg = 'Missing order id to continue operation.';
          redirect_page($path, 'orders.php', '4', $msg, 'Illegal request');
          exit;
        }
        $order_id = $_POST['orderid'];
        
        delete_order($order_id, $path);
        exit;
        
      } elseif (isset($_POST['type']) && $_POST['type'] == 'view') {
        // view details or edit
        if (!isset($_POST['orderid'])) {
          $msg = 'Missing order id to continue operation.';
          redirect_page($path, 'orders.php', '4', $msg, 'Illegal request');
          exit;
        }
        $order_id = $_POST['orderid'];
        
        show_order_detail($order_id, $path);
        exit;
        
      } elseif (isset($_POST['type']) && $_POST['type'] == 'confirm') {
        // confirm one order
        if (!isset($_POST['orderid'])) {
          $msg = 'Missing order id to continue operation.';
          redirect_page($path, 'orders.php', '4', $msg, 'Illegal request');
          exit;
        }
        $order_id = $_POST['orderid'];
        
        $obj = Order::get_order_by_orderid($order_id);
        
        if (!$obj) {
          $msg = 'Not found this order id in database';
          redirect_page($path, 'orders.php', '4', $msg, 'Illegal request');
          exit;
        }
        // change status to 'confirmed'
        if ($obj->status != 'processing') {
          $msg = 'Confirmed order could not be changed anymore.';
          redirect_page($path, 'orders.php', '4', $msg, 'Illegal request');
          exit;
        }
        
        $order = new Order();
        $order->init_from_db_object($obj);
        $order->set_status('confirmed');
        
        if (!($order->update_in_db())) {
          $msg = 'Can not update order info this time';
          redirect_page($path, 'orders.php', '4', $msg, 'Unknown error!!!');
          exit;
        }
        
        // generate a new notification to customer
        $notification = new Notification();
        $notification->set_userid($obj->user_id);
        $notification->set_title('Order has been confirmed.');
        $msg = 'Your order for ' . $order->get_flight_no() . ' on ' 
                . $order->get_flight_date() . ' has been confirmed. '
              . 'You can not edit it from now on.';
        $notification->set_message($msg);
        if (!($notification->insert_to_db())) {
          $msg = 'Can not generate notification';
          redirect_page($path, 'orders.php', '4', $msg, 'Unknown error!!!');
          exit;
        }
        
      }
      
      // show order list
      show_order_list($path);
      exit;
      
    } else { // illegal user request
      $msg = 'You can not perform this operation, redirect to '
             . '<a href="login.php">sign-in</a> page.';
      redirect_page($path, 'login.php', '4', $msg, 'Operation failed');
    }
  
    
  } catch (Exception $e) {
    $msg = $e->getMessage();
    redirect_page($path, 'index.php', '4', $msg, 'Operation failed');
  }
  
  
?>
