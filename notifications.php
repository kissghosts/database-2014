<?php

  /**
  * controller for notifications
  * view notificaitons, and delete notifications
  *
  * @author yfliu
  */

  require_once 'lib/view_components.php';
  require_once 'lib/models/user.php';
  require_once 'lib/models/notification.php';

  // start session
  session_start();
  $path = '';
  
  try { // in case that any unknown error happens (e.g. db error)
    
    if (isset($_SESSION['valid_user'])) { // for customer
      $user_id = $_SESSION['valid_user'];
    
      if (isset($_GET['id'])) { // display specified notification with id
        $id = $_GET['id'];
        $notification = new Notification();
        $obj = Notification::get_notification_by_id($id);
        
        if (!$obj) {
          $msg = 'Error: no such notification found in database';
          redirect_page($path, 'notifications.php', '4', $msg, 'Illegal query!!!');
          exit;
        }
        $notification->init_from_db_object($obj);
        if (!($notification->update_isread_flag_in_db())) {
          $msg = 'Can not update notification status in database';
          redirect_page($path, 'notifications.php', '4', $msg, 'Unknown error!!!');
          exit;
        }
        // html view
        require 'views/html_header.php';
        require 'views/navbar.php';
        require 'views/notification_detail.php';
        require 'views/html_footer.php';
        exit;
      } elseif (isset($_POST['type']) && $_POST['type'] == 'delete') { // delete
      
        // delete one order
        if (!isset($_POST['id'])) {
          $msg = 'Missing notification id to continue operation.';
          redirect_page($path, 'notifications.php', '4', $msg, 'Illegal request');
          exit;
        }
        $id = $_POST['id'];
        $result = Notification::delete_notifaction_by_id($id);
        if (!$result) {
          $msg = 'Can not delete entity in table notifications';
          redirect_page($path, 'notifications.php', '4', $msg, 'Operation failed');
          exit;
        }
      }
      
      // notification list view
      $limit = 10;
      $offset = 0;
      $currnt_page = 0;  // start page number is 0 (the first index page)
      $notifications = array();

      if (isset($_GET['page'])) {
        $page = (int)$_GET['page'];
        $current_page = $page;
        if ($page >= 1) {
          $offset = $page * $limit; 
        }
      }

      $notification_total_num = Notification::get_notification_num_by_userid($user_id);
      $total_page_num = ceil($notification_total_num/$limit);

      foreach(Notification::get_notifications_by_userid($user_id, $limit, $offset) as $n) {
        $notification = new Notification();
        $notification->init_from_db_object($n);
        $notifications[] = $notification;
      }

      // html view
      require 'views/html_header.php';
      require 'views/navbar.php';
      require 'views/notification_list.php';
      require 'views/html_footer.php';
      
      
      
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