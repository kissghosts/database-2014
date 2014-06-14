<?php


/**
 * Description of cart_item
 *
 * @author yfliu
 */

require_once(dirname(__FILE__).'/../db.php');

class CartItem {
  private $item_id;
  private $quantity;
  private $product_id;
  private $user_id;
  
  public function __construct() {
    // currently empty
  }
  
  
  /*
   * get cart_id by specifying user_id and product_id
   * input: $user_id, $product_id
   * return string id when successful, or false
   */
  public static function get_item_id_by_userid_and_productid($user_id, $product_id) {
    // connect to db
    $conn = get_db_connection();
    $sql = "SELECT cart_item_id FROM cart_items WHERE user_id=? and product_id=?";
    $query = $conn->prepare($sql);
    $query->execute(array($user_id, $product_id));

    $r = $query->fetch();
    if (empty($r)) {
      return FALSE;
    } else {
      return $r[0];
    }
  }
  
  /*
   * get cart_item object
   * input: $user_id, $product_id
   * return cart_item object
   */
  public static function get_item_by_userid_and_productid($user_id, $product_id) {
    // connect to db
    $conn = get_db_connection();
    $sql = "SELECT * FROM cart_items WHERE user_id=? and product_id=?";
    $query = $conn->prepare($sql);
    $query->execute(array($user_id, $product_id));

    $r = $query->fetch(PDO::FETCH_OBJ);
    return $r;
  }
  
  public static function get_item_by_itemid($item_id) {
    // pass
  }
  
  /*
   * delete item
   * input: item_id
   * return true or false
   */
  public static function delete_item_by_id($item_id) {
    // connect to db
    $conn = get_db_connection();
    $sql = "DELETE FROM cart_items WHERE cart_item_id = ?";
    $query = $conn->prepare($sql);
    $r = $query->execute(array($item_id));

    return $r;
  }
  
  /*
   * update quantity
   * input: item_id
   * return true or false
   */
  public static function update_quantity_by_id($item_id, $quantity) {
    // connect to db
    $conn = get_db_connection();
    $sql = "UPDATE cart_items SET quantity = ? WHERE cart_item_id = ?";
    $query = $conn->prepare($sql);
    $r = $query->execute(array($quantity, $item_id));

    return $r;
  }
  
  public static function add_item_to_db($user_id, $product_id) {
    // pass
  }
  
  /*
   * get all cart item objects for a specified user
   * input: $user_id, $limit, $offset
   * return cart_item object array (fetchAll(PDO::FETCH_OBJ))
   */
  public static function get_items_by_userid($user_id, $limit, $offset) {
    // connect to db
    $conn = get_db_connection();
    $sql = "SELECT * FROM cart_items WHERE user_id = ? "
            . "ORDER BY cart_item_id DESC LIMIT ? OFFSET ?";
    $query = $conn->prepare($sql);
    $query->execute(array($user_id, $limit, $offset));

    $rows = $query->fetchAll(PDO::FETCH_OBJ);
    return $rows;
  }
  
  /*
   * get all cart item objects for a specified user
   * input: $user_id
   * return cart_item object array (fetchAll(PDO::FETCH_OBJ))
   */
  public static function get_all_items_by_userid($user_id) {
    // connect to db
    $conn = get_db_connection();
    $sql = "SELECT * FROM cart_items WHERE user_id = ? ";
    $query = $conn->prepare($sql);
    $query->execute(array($user_id));

    $rows = $query->fetchAll(PDO::FETCH_OBJ);
    return $rows;
  }
  
  /*
   * get row number of items for a specified user
   * return row number
   */
  public static function get_item_num_by_userid($user_id) {
    $sql = "SELECT count(*) FROM cart_items WHERE user_id = ?";
    $query = get_db_connection()->prepare($sql);
    $query->execute(array($user_id));
    return $query->fetchColumn();
  }
  
  
  
  
  
  
  
  public function get_item_id() {
    return $this->item_id;
  }
  
  public function get_user_id() {
    return $this->user_id;
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
  
  public function set_user_id($uid) {
    $this->user_id = $uid;
  }
  
  public function set_quantity($quantity) {
    $this->quantity = $quantity;
  }
  
  public function add_one_to_quantity() {
    $this->quantity++;
  }
  
  public function init_from_db_object($obj) {
    $this->set_item_id($obj->cart_item_id);
    $this->set_product_id($obj->product_id);
    $this->set_user_id($obj->user_id);
    $this->set_quantity($obj->quantity);
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
    $sql = "UPDATE cart_items SET quantity = ? WHERE cart_item_id = ?";
    
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
    $sql = "INSERT INTO cart_items (user_id, product_id, quantity) VALUES "
            . "(?, ?, ?) RETURNING cart_item_id";
    $query = $conn->prepare($sql);
    $id = $query->execute(array($this->user_id, $this->product_id, $this->quantity));

    return $id;
  }
}
