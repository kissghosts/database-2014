<?php

/**
 * Description of product
 *
 * @author yfliu
 */

require_once(dirname(__FILE__).'/../db.php');

class Product {
  private $id;
  private $name;
  private $category;
  private $brand;
  private $price;
  private $img;
  private $description;
  
  public function __construct($id, $name, $category, $brand, $price, $img, $descrpt) {
    $this->id = $id;
    $this->name = $name;
    $this->category = $category;
    $this->brand = $brand;
    $this->price = $price;
    $this->img = $img;
    $this->description = $descrpt;
  }
  
  /*
   * add new product into db
   * return true if successful
   */
  public static function add_product_to_db($name, $category, $brand, $price, $img, $des) {
    // connect to db
    $conn = get_db_connection();
    // check if username is unique
    $sql = "SELECT * FROM products WHERE name='".$name
            ."' and category='".$category."'";
    $query = $conn->prepare($sql);
    $query->execute();
    $result = $query->fetch();

    if ($result) {
      throw new Exception('Same product exists.');
    }

    // if ok, add in db
    $sql = "INSERT INTO products "
            . "(name, category, brand, price, imgurl, description) VALUES "
            . "(:name,:category,:brand,:price,:imgurl,:description)";
    $query = $conn->prepare($sql);
    $result = $query->execute(array(':name'=>$name,
                                    ':category'=>$category,
                                    ':brand'=>$brand,
                                    ':price'=>$price,
                                    ':imgurl'=>$img,
                                    ':description'=>$des));

    if (!$result) {
      return false;
    }
    return true;
  }
  
  /*
   * get all existing distinct categories from db
   * return PDO fetchAll array (two-level array)
   */
  public static function get_all_categories() {
    // connect to db
    $conn = get_db_connection();
    $sql = "SELECT DISTINCT category FROM products ORDER BY category";
    $query = $conn->prepare($sql);
    $query->execute();

    $rows = $query->fetchAll();
    return $rows;
  }
  
  /*
   * get row number of current products table in db
   * return row number
   */
  public static function get_product_num() {
    $sql = "SELECT count(*) FROM products";
    $query = get_db_connection()->prepare($sql);
    $query->execute();
    return $query->fetchColumn();
  }
  
  /*
   * get row number of products from a specified category
   * return row number
   */
  public static function get_product_num_by_category($category) {
    $sql = "SELECT count(*) FROM products WHERE category='" . $category . "'";
    $query = get_db_connection()->prepare($sql);
    $query->execute();
    return $query->fetchColumn();
  }

  /*
   * get existing products from db
   * input: sql select limit number and offset, these are required for
   *        display products with pagination
   * return PDO fetchAll array (stype PDO::FETCH_OBJ)
   */
  public static function get_products($limit, $offset) {
    // connect to db
    $conn = get_db_connection();
    $sql = "SELECT * FROM products ORDER BY name LIMIT ? OFFSET ?";
    $query = $conn->prepare($sql);
    $query->execute(array($limit, $offset));

    $rows = $query->fetchAll(PDO::FETCH_OBJ);
    return $rows;
  }
  
  /*
   * get products from a specific category
   * input: category in string
   *        limit, offset
   * return PDO fetchAll array (stype PDO::FETCH_OBJ)
   */
  public static function get_products_by_category($category, $limit, $offset) {
    // connect to db
    $conn = get_db_connection();
    $sql = "SELECT * FROM products WHERE category='" . $category 
            . "' ORDER BY name LIMIT ? OFFSET ?";
    $query = $conn->prepare($sql);
    $query->execute(array($limit, $offset));

    $rows = $query->fetchAll(PDO::FETCH_OBJ);
    return $rows;
  }
  
  
  
  
  
  public function get_id() {
    return $this->id;
  }
  
  public function get_name() {
    return $this->name;
  }
  
  public function set_name($n) {
    $this->name = $n;
  }
  
  public function get_category() {
    return $this->category;
  }
  
  public function set_category($c) {
    $this->category = $c;
  }
  
  public function get_brand() {
    return $this->brand;
  }
  
  public function get_price() {
    return $this->price;
  }
  
  public function get_image_info() {
    return $this->img;
  }
  
  public function get_description() {
    return $this->description;
  }
  
}
