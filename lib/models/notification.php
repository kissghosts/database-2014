<?php

/**
 * corresponding to the table notificaiton in db
 * all the database-related functions are put here
 *
 * @author yfliu
 */


require_once(dirname(__FILE__).'/../db.php');

class Notification {
  private $id;
  private $user_id;
  private $title;
  private $message;
  private $is_read;
  private $add_date;
  
  /*
   * get notification with a specific id
   * input: id
   * return PDO fetched array (style PDO::FETCH_OBJ)
   */
  public static function get_notification_by_id($id) {
    // connect to db
    $conn = get_db_connection();
    $sql = "SELECT * FROM notifications WHERE notification_id = ?";
    $query = $conn->prepare($sql);
    $query->execute(array($id));

    $r = $query->fetch(PDO::FETCH_OBJ);
    return $r;
  }
  
  /*
   * get a specific user's notifications
   * input: user_id
   *        limit, offset
   * return PDO fetchAll array (style PDO::FETCH_OBJ)
   */
  public static function get_notifications_by_userid($user_id, $limit, $offset) {
    // connect to db
    $conn = get_db_connection();
    $sql = "SELECT * FROM notifications WHERE user_id = ? "
            . "ORDER BY notification_id DESC LIMIT ? OFFSET ?";
    $query = $conn->prepare($sql);
    $query->execute(array($user_id, $limit, $offset));

    $rows = $query->fetchAll(PDO::FETCH_OBJ);
    return $rows;
  }
  
  /*
   * get all of the unread notifications
   * input: user_id, limit, offset
   * return PDO fetchAll array (style PDO::FETCH_OBJ)
   */
  public static function get_unread_notifications_by_userid($user_id, $limit, $offset) {
    // connect to db
    $conn = get_db_connection();
    $sql = "SELECT * FROM notifications WHERE user_id = ? AND is_read = ? "
            . "ORDER BY order_id DESC LIMIT ? OFFSET ?";
    $query = $conn->prepare($sql);
    $query->execute(array($user_id, 'false', $limit, $offset));

    $rows = $query->fetchAll(PDO::FETCH_OBJ);
    return $rows;
  }
  
  /*
   * get row number of unread notifications by userid
   * return row number
   */
  public static function get_unread_notification_num_by_userid($user_id) {
    $sql = "SELECT count(*) FROM notifications WHERE user_id = ? AND "
          . "is_read = ? ";
    $query = get_db_connection()->prepare($sql);
    $query->execute(array($user_id, 'false'));
    return $query->fetchColumn();
  }
  
  /*
   * get row number of notifications by user_id
   * return row number
   */
  public static function get_notification_num_by_userid($user_id) {
    $sql = "SELECT count(*) FROM notifications WHERE user_id = ?";
    $query = get_db_connection()->prepare($sql);
    $query->execute(array($user_id));
    return $query->fetchColumn();
  }
  
  /*
   * delete notification
   * input: id
   * return empty if failed
   */
  public static function delete_notifaction_by_id($id) {
    // connect to db
    $conn = get_db_connection();
    $sql = "DELETE FROM notifications WHERE notification_id = ?";
    $query = $conn->prepare($sql);
    $r = $query->execute(array($id));

    return $r;
  }
  
  /*
   * updata is_read info in db
   * return true or false
   */
  public static function read_notification($id) {
    // connect to db
    $conn = get_db_connection();
    $sql = "UPDATE notifications SET is_read = ? WHERE notification_id = ?";

    $query = $conn->prepare($sql);
    $result = $query->execute(array('true', $id));
    return $result;
  }
  
  
  
  
  
  
  
  public function __construct() {
    // currently empty
    // use setter to init
  }
  
  public function set_title($title) {
    $this->title = trim($title);
  }
  
  public function get_title() {
    return $this->title;
  }
  
  public function get_id() {
    return $this->id;
  }
  
  public function set_id($id) {
    // currently no restriction on this :)
    $this->id = $id;
  }
  
  public function get_date() {
    return $this->add_date;
  }
  
  public function set_date($add_date) {
    // currently no restriction on this :)
    $this->add_date = $add_date;
  }
  
  public function get_userid() {
    return $this->user_id;
  }
  
  public function set_userid($user_id) {
    // currently no restriction on this :)
    $this->user_id = $user_id;
  }
  
  public function get_message() {
    return $this->message;
  }
  
  public function set_message($message) {
    // currently no restriction on this :)
    $this->message = trim($message);
  }
  
  public function get_isread_flag() {
    return $this->is_read;
  }
  
  public function set_isread_flag($flag) {
    // currently no restriction on this :)
    $this->is_read = $flag;
  }
  
  public function init_from_db_object($obj) {
    $this->set_id($obj->notification_id);
    $this->set_userid($obj->user_id);
    $this->set_title($obj->title);
    $this->set_message($obj->message);
    $this->set_isread_flag($obj->is_read);
    $this->set_date($obj->add_date);
  }
  
  /*
   * add new notification into db
   * return true or false successful
   */
  public function insert_to_db() {
    // connect to db
    $conn = get_db_connection();
    $sql = "INSERT INTO notifications (user_id, title, message, is_read, add_date) "
          . "VALUES (?, ?, ?, ?, CAST(? AS DATE)) RETURNING notification_id";
    $query = $conn->prepare($sql);
    
    $result = $query->execute(array($this->user_id, $this->title, 
                                $this->message, 'false', date('Y-m-d')));

    if ($result) {
      $this->id = $query->fetchColumn();
    }
    return $result;
  }
  
  /*
   * updata is_read info in db
   * return true or false
   */
  public function update_isread_flag_in_db() {
    // connect to db
    $conn = get_db_connection();
    $sql = "UPDATE notifications SET is_read = ? WHERE notification_id = ?";

    $query = $conn->prepare($sql);
    $result = $query->execute(array('true', $this->id));
    return $result;
  }
  
}
