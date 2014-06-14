<?php

require_once(dirname(__FILE__).'/../db.php');

class OrderItem {
  private $item_id;
  private $quantity;
  private $product_id;
  private $order_id;
  
  public function __construct() {
    // currently empty
  }
  
  
  /*
   * get order_item object
   * input: $order_id
   * return item object
   */
  public static function get_item_by_orderid($order_id) {
    // connect to db
    $conn = get_db_connection();
    $sql = "SELECT * FROM order_items WHERE order_id = ?";
    $query = $conn->prepare($sql);
    $query->execute(array($order_id));

    $r = $query->fetch(PDO::FETCH_OBJ);
    return $r;
  }
  
  /*
   * get order_item object
   * input: $item_id
   * return item object
   */
  public static function get_item_by_itemid($item_id) {
    // connect to db
    $conn = get_db_connection();
    $sql = "SELECT * FROM order_items WHERE order_item_id = ?";
    $query = $conn->prepare($sql);
    $query->execute(array($item_id));

    $r = $query->fetch(PDO::FETCH_OBJ);
    return $r;
  }
  
  /*
   * delete item
   * input: item_id
   * return true or false
   */
  public static function delete_item_by_itemid($item_id) {
    // connect to db
    $conn = get_db_connection();
    $sql = "DELETE FROM order_items WHERE order_item_id = ?";
    $query = $conn->prepare($sql);
    $r = $query->execute(array($item_id));

    return $r;
  }
  
  /*
   * update quantity
   * input: item_id
   * return true or false
   */
  public static function update_quantity_by_itemid($item_id, $quantity) {
    // connect to db
    $conn = get_db_connection();
    $sql = "UPDATE order_items SET quantity = ? WHERE order_item_id = ?";
    $query = $conn->prepare($sql);
    $r = $query->execute(array($quantity, $item_id));

    return $r;
  }
  
  /*
   * add new item into db
   * return cart_item_id (empty if failed)
   */
  public static function add_item_to_db($order_id, $product_id, $quantity) {
    // connect to db
    $conn = get_db_connection();
    $sql = "INSERT INTO order_items (order_id, product_id, quantity) VALUES "
            . "(?, ?, ?) RETURNING order_item_id";
    $query = $conn->prepare($sql);
    $id = $query->execute(array($order_id, $product_id, $quantity));

    return $id;
    
  }
  
  /*
   * get all item objects for a specified order
   * input: $order_id, $limit, $offset
   * return item object array (fetchAll(PDO::FETCH_OBJ))
   */
  public static function get_items_by_orderid($order_id, $limit, $offset) {
    // connect to db
    $conn = get_db_connection();
    $sql = "SELECT * FROM order_items WHERE order_id = ? "
            . "ORDER BY order_item_id DESC LIMIT ? OFFSET ?";
    $query = $conn->prepare($sql);
    $query->execute(array($order_id, $limit, $offset));

    $rows = $query->fetchAll(PDO::FETCH_OBJ);
    return $rows;
  }
  
  /*
   * get row number of items for a specified user
   * return row number
   */
  public static function get_item_num_by_orderid($order_id) {
    $sql = "SELECT count(*) FROM order_items WHERE order_id = ?";
    $query = get_db_connection()->prepare($sql);
    $query->execute(array($order_id));
    return $query->fetchColumn();
  }
  
  
  
  
  
  
  
  public function get_item_id() {
    return $this->item_id;
  }
  
  public function get_order_id() {
    return $this->order_id;
  }
  
  public function get_product_id() {
    return $this->product_id;
  }
  
  public function get_quantity() {
    return $this->quantity;
  }
  
  public function set_item_id($item_id) {
    $this->item_id = $item_id;
  }

  public function set_product_id($pid) {
    $this->product_id = $pid;
  }
  
  public function set_order_id($uid) {
    $this->order_id = $uid;
  }
  
  public function set_quantity($quantity) {
    $this->quantity = $quantity;
  }
  
  public function init_from_db_object($obj) {
    $this->set_item_id($obj->order_item_id);
    $this->set_product_id($obj->product_id);
    $this->set_order_id($obj->order_id);
    $this->set_quantity($obj->quantity);
  }
  
  public function init_attributes($order_id, $product_id, $quantity) {
    $this->set_product_id($product_id);
    $this->set_order_id($order_id);
    $this->set_quantity($quantity);
  }
  
  /*
   * updata item quantity in db
   * 
   */
  public function update_quantity_in_db() {
    if (!isset($this->item_id)) {
      return FALSE;
    }

    // connect to db
    $conn = get_db_connection();
    $sql = "UPDATE order_items SET quantity = ? WHERE order_item_id = ?";
    
    $query = $conn->prepare($sql);
    $result = $query->execute(array($this->quantity, $this->item_id));
    return $result;
  }
  
  /*
   * add new item into db
   * return cart_item_id (empty if failed)
   */
  public function insert_to_db() {
    // connect to db
    $conn = get_db_connection();
    $sql = "INSERT INTO order_items (order_id, product_id, quantity) VALUES "
            . "(?, ?, ?) RETURNING order_item_id";
    $query = $conn->prepare($sql);
    $id = $query->execute(array($this->order_id, $this->product_id, $this->quantity));

    return $id;
  }
}