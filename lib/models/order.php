<?php

require_once(dirname(__FILE__).'/../db.php');

/**
 * model class for table orders
 * all the database-related functions are defined here
 *
 * @author yfliu
 */

class Order {
  private $order_id;
  private $user_id;
  private $user_name;
  private $flight_no;
  private $flight_date;
  private $flight_seat;
  private $booking_date;
  private $status;
  private $requirement;
  
  private $errors = array();  // used for input validation

  public function __construct() {
    // put attribute initialization in each setter
  }  
  
  /*
   * get order with a specific id
   * input: order_id
   * return PDO fetched array (style PDO::FETCH_OBJ)
   */
  public static function get_order_by_orderid($order_id) {
    // connect to db
    $conn = get_db_connection();
    $sql = "SELECT * FROM orders WHERE order_id = ?";
    $query = $conn->prepare($sql);
    $query->execute(array($order_id));

    $r = $query->fetch(PDO::FETCH_OBJ);
    return $r;
  }
  
  /*
   * get a specific user's orders 
   * input: user_id
   *        limit, offset
   * return PDO fetchAll array (style PDO::FETCH_OBJ)
   */
  public static function get_orders_by_userid($user_id, $limit, $offset) {
    // connect to db
    $conn = get_db_connection();
    $sql = "SELECT * FROM orders WHERE user_id = ? "
            . "ORDER BY order_id DESC LIMIT ? OFFSET ?";
    $query = $conn->prepare($sql);
    $query->execute(array($user_id, $limit, $offset));

    $rows = $query->fetchAll(PDO::FETCH_OBJ);
    return $rows;
  }
  
  /*
   * get all of the unconfirmed orders
   * input: limit, offset
   * return PDO fetchAll array (style PDO::FETCH_OBJ)
   */
  public static function get_unconfirmed_orders($limit, $offset) {
    // connect to db
    $conn = get_db_connection();
    $sql = "SELECT * FROM orders WHERE status = ? "
            . "ORDER BY order_id DESC LIMIT ? OFFSET ?";
    $query = $conn->prepare($sql);
    $query->execute(array('processing', $limit, $offset));

    $rows = $query->fetchAll(PDO::FETCH_OBJ);
    return $rows;
  }
  
  /*
   * get all of the unconfirmed orders by flight number
   * input: limit, offset
   * return PDO fetchAll array (style PDO::FETCH_OBJ)
   */
  public static function get_unconfirmed_orders_by_flightno_and_flightdate(
      $flight_no, $flight_date, $limit, $offset) {
    // connect to db
    $conn = get_db_connection();
    $sql = "SELECT * FROM orders WHERE status = ? AND flight_no = ?"
            . " AND flight_date = ? ORDER BY order_id DESC LIMIT ? OFFSET ?";
    $query = $conn->prepare($sql);
    $query->execute(array('processing', $flight_no, $flight_date, $limit, $offset));

    $rows = $query->fetchAll(PDO::FETCH_OBJ);
    return $rows;
  }
  
  /*
   * get row number of unconfirmed orders by flightno
   * return row number
   */
  public static function get_unconfirmed_order_num_by_flightno_and_flightdate(
      $flight_no, $flight_date) {
    $sql = "SELECT count(*) FROM orders WHERE status = ? AND flight_no = ? "
          . "AND flight_date = ?";
    $query = get_db_connection()->prepare($sql);
    $query->execute(array('processing', $flight_no, $flight_date));
    return $query->fetchColumn();
  }
  
  /*
   * get row number of unconfirmed orders
   * return row number
   */
  public static function get_unconfirmed_order_num() {
    $sql = "SELECT count(*) FROM orders WHERE status = ?";
    $query = get_db_connection()->prepare($sql);
    $query->execute(array('processing'));
    return $query->fetchColumn();
  }
  
  /*
   * get row number of orders
   * return row number
   */
  public static function get_order_num_by_userid($user_id) {
    $sql = "SELECT count(*) FROM orders WHERE user_id = ?";
    $query = get_db_connection()->prepare($sql);
    $query->execute(array($user_id));
    return $query->fetchColumn();
  }
  
  /*
   * delete order
   * input: id
   * return empty if failed
   */
  public static function delete_order_by_orderid($order_id) {
    // connect to db
    $conn = get_db_connection();
    $sql = "DELETE FROM orders WHERE order_id = ?";
    $query = $conn->prepare($sql);
    $r = $query->execute(array($order_id));

    return $r;
  }
  
  
  
  
  
  
  public function set_orderid($order_id) {
    $this->order_id = $order_id;
  }
  
  public function get_orderid() {
    return $this->order_id;
  }
  
  public function set_userid($user_id) {
    $this->user_id = $user_id;
  }
  
  public function get_userid() {
    return $this->user_id;
  }
  
  public function set_user_name($user_name) {
    $this->user_name = trim($user_name);
    
    if ($this->user_name == '') {
      $this->errors['user_name'] = "Customer name should not be blank.";
    } elseif (strlen($this->user_name) >= 126) {
      $this->errors['user_name'] = "Customer name is too long.";
    } else { 
      unset($this->errors['user_name']);
    }
  }
  
  public function get_user_name() {
    return $this->user_name;
  }
  
  public function set_flight_no($flight_no) {
    $this->flight_no = strtoupper(trim($flight_no));
    
    if ($this->flight_no == '') {
      $this->errors['flight_no'] = "flight_no should not be blank.";
    } elseif (strlen($this->flight_no) >= 9) {
      $this->errors['flight_no'] = "flight_no could at most contain 9 characters.";
    } else { 
      unset($this->errors['flight_no']);
    }
  }
  
  public function get_flight_no() {
    return $this->flight_no;
  }
  
  public function set_flight_date($flight_date) {
    $this->flight_date = trim($flight_date);
    
    if ($this->flight_date == '') {
      $this->errors['flight_date'] = "You mush give a legal flight date";
    } elseif (preg_match('/^(\d{4}-\d{2}-\d{2})$/', $this->flight_date) != 1) {
      $this->errors['flight_date'] = "Unexpected data format, "
                                    . "should be like this yyyy-mm-dd";
    } else { // validate date, can not choose a passed date
      $today = date('Y-m-d');
      $cur_date = strtotime($today);
      $input_date = strtotime($this->flight_date);
      
      if ($cur_date > $input_date) {
        $this->errors['flight_date'] = "Please choose a flight date from tomorrow";
        
      } else {
        unset($this->errors['flight_date']);
      }
    }
  }
  
  public function get_flight_date() {
    return $this->flight_date;
  }
  
  public function set_flight_seat($flight_seat) {
    $this->flight_seat = trim($flight_seat);
    
    if (strlen($this->flight_seat) >= 9) {
      $this->errors['flight_seat'] = "flight seat could at most contain 9 characters.";
    } else { 
      unset($this->errors['flight_seat']);
    }
  }
  
  public function get_flight_seat() {
    return $this->flight_seat;
  }
  
  // this attribute should not be set by customer
  public function set_booking_date($booking_date) {
    $this->booking_date = trim($booking_date);
    
    if ($this->booking_date == '') {
      $this->errors['booking_date'] = "booking date should not be bland";
    } elseif (preg_match('/^(\d{4}-\d{2}-\d{2})$/', $this->booking_date) != 1) {
      $this->errors['booking_date'] = "Unexpected data format, "
                                    . "should be like this yyyy-mm-dd";
    } else { 
      unset($this->errors['booking_date']);
    }
  }
  
  public function get_booking_date() {
    return $this->booking_date;
  }
  
  public function set_status($status) {
    $this->status = trim($status);
    
    if ($this->status != 'processing' && $this->status != 'confirmed') {
      $this->errors['status'] = "unsupported status: " . $this->status;
    } else { 
      unset($this->errors['status']);
    }
  }
  
  public function get_status() {
    return $this->status;
  }
  
  public function get_requirement() {
    return $this->requirement;
  }
  
  public function set_requirement($requirement) {
    // currently no restriction on this :)
    
    $this->requirement = trim($requirement);
  }
  
  public function init_from_db_object($obj) {
    $this->set_orderid($obj->order_id);
    $this->set_userid($obj->user_id);
    $this->set_user_name($obj->user_name);
    $this->set_flight_no($obj->flight_no);
    $this->set_flight_date($obj->flight_date);
    $this->set_flight_seat($obj->flight_seat);
    $this->set_booking_date($obj->booking_date);
    $this->set_status($obj->status);
    $this->set_requirement($obj->requirement);
  }
  
  public function contains_error_attribute() {
    return !empty($this->errors);
  }
  
  public function get_error_array() {
    return $this->errors;
  }
  
  
  /*
   * add new order into db
   * return true or false
   */
  public function insert_to_db() {
    // connect to db
    $conn = get_db_connection();
    $sql = "INSERT INTO orders "
            . "(user_id, user_name, flight_no, flight_date, flight_seat, "
            . "booking_date, status, requirement) VALUES "
            . "(?, ?, ?, CAST(? AS DATE), ?, CAST(? AS DATE), ?, ?) "
            . "RETURNING order_id";
    $query = $conn->prepare($sql);
    
    $date = date('Y-m-d');
    $result = $query->execute(array($this->user_id, $this->user_name, 
                                $this->flight_no, $this->flight_date, 
                                $this->flight_seat, $date, 
                                'processing', $this->requirement));

    if ($result) {
      $this->order_id = $query->fetchColumn();
    }
    return $result;
  }
  
  /*
   * updata order info in db
   * return true or false
   */
  public function update_in_db() {
    // connect to db
    $conn = get_db_connection();
    $sql = "UPDATE orders SET user_name = ?, flight_no = ?, "
            . "flight_date = CAST(? AS DATE), flight_seat = ?, "
            . "booking_date = CAST(? AS DATE), status = ?, "
            . "requirement = ? WHERE order_id = ?";

    $query = $conn->prepare($sql);
    $result = $query->execute(array($this->user_name, $this->flight_no, 
                                    $this->flight_date, $this->flight_seat, 
                                    $this->booking_date, $this->status, 
                                    $this->requirement, $this->order_id));
    return $result;
  }
  
  
}
