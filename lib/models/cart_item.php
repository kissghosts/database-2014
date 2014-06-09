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
  
  public static function get_item_by_userid_and_productid($user_id, $product_id) {
    
  }
  
  public static function get_item_by_itemid($item_id) {
    
  }
  
  public static function add_item_to_db($user_id, $product_id) {
    
  }
  
  public static function get_items_by_userid($user_id) {
    
  }
}
