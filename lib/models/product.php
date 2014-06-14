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
  private $errors = array();
  
  public function __construct() {
    // put attribute initialization in each setter
  }
  
//  public function __construct($id, $name, $category, $brand, $price, $img, $descrpt) {
//    $this->id = $id;
//    $this->name = $name;
//    $this->category = $category;
//    $this->brand = $brand;
//    $this->price = $price;
//    $this->img = $img;
//    $this->description = $descrpt;
//  }
  
  
  /*
   * get product with a specific name and category
   * input: name, category
   * return PDO fetched array (style PDO::FETCH_OBJ)
   */
  public static function get_product_by_name_and_category($name, $category) {
    // connect to db
    $conn = get_db_connection();
    $sql = "SELECT * FROM products WHERE name='" . $name . "' and category='"
          .$category . "'";
    $query = $conn->prepare($sql);
    $query->execute();

    $r = $query->fetch(PDO::FETCH_OBJ);
    return $r;
  }
  
  /*
   * add new product into db
   * return true if successful
   */
  public static function add_product_to_db($name, $category, $brand, $price, $img, $des) {
    // connect to db
    $conn = get_db_connection();
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

    return $result;
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
   * return PDO fetchAll array (style PDO::FETCH_OBJ)
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
   * return PDO fetchAll array (style PDO::FETCH_OBJ)
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
  
  /*
   * search product
   * input: keyword string, limit, offset
   * return PDO fetchAll array (style PDO::FETCH_OBJ)
   */
  public static function search_products($keyword, $limit, $offset) {
    // connect to db
    $conn = get_db_connection();
    $sql = "SELECT * FROM products WHERE lower(name) LIKE ? OR lower(brand) LIKE ? "
            . "ORDER BY name LIMIT ? OFFSET ?";
    $query = $conn->prepare($sql);
    $query->execute(array('%'.$keyword.'%', '%'.$keyword.'%', $limit, $offset));

    $rows = $query->fetchAll(PDO::FETCH_OBJ);
    return $rows;
  }
  
  /*
   * get row number of products from a specified search
   * return row number
   */
  public static function get_product_num_by_search($keyword) {
    $sql = "SELECT count(*) FROM products WHERE lower(name) = ? OR lower(brand) = ?";
    $query = get_db_connection()->prepare($sql);
    $query->execute(array($keyword, $keyword));
    return $query->fetchColumn();
  }
  
  /*
   * get product with a specific id
   * input: id
   * return PDO fetched array (style PDO::FETCH_OBJ)
   */
  public static function get_product_by_id($id) {
    // connect to db
    $conn = get_db_connection();
    $sql = "SELECT * FROM products WHERE product_id='" . $id . "'";
    $query = $conn->prepare($sql);
    $query->execute();

    $row = $query->fetch(PDO::FETCH_OBJ);
    return $row;
  }
  
  
  /*
   * delete product
   * input: id
   * return true or false
   */
  public static function delete_product_by_id($id) {
    // connect to db
    $conn = get_db_connection();
    $sql = "DELETE FROM products WHERE product_id = '" . $id . "'";
    $query = $conn->prepare($sql);
    $r = $query->execute();

    return $r;
  }
  
  
  
  public function set_id($id) {
    $this->id = $id;
  }
  
  public function get_id() {
    return $this->id;
  }
  
  public function set_name($name) {
    $this->name = trim($name);
    
    if ($this->name == '') {
      $this->errors['name'] = "Name should not be blank.";
    } elseif (strlen($this->name) >= 126) {
      $this->errors['name'] = "Name is too long.";
    } else { 
      unset($this->errors['name']);
    }
  }
  
  public function get_name() {
    return $this->name;
  }
  
  public function get_category() {
    return $this->category;
  }
  
  public function set_category($category) {
    $this->category = trim($category);
    
    if ($this->category == '') {
      $this->errors['category'] = "Category should not be blank.";
    } elseif (strlen($this->category) >= 62) {
      $this->errors['category'] = "Category is too long.";
    } else { 
      unset($this->errors['category']);
    }
  }
  
  public function get_brand() {
    return $this->brand;
  }
  
  public function set_brand($brand) {
    $this->brand = trim($brand);
    
    if ($this->brand == '') {
      $this->errors['brand'] = "Brand should not be blank.";
    } elseif (strlen($this->brand) >= 126) {
      $this->errors['brand'] = "Brand is too long.";
    } else { 
      unset($this->errors['brand']);
    }
  }
  
  public function get_price() {
    return $this->price;
  }
  
  public function set_price($price) {
    $this->price = $price;
    
    if (!is_numeric($this->price)) {
      $this->errors['price'] = "Price should be a number.";
    } else if ($this->price <= 0) {
      $this->errors['price'] = "Price should be a positive number.";
    } else {
      unset($this->errors['price']);
    }
  }
  
  public function get_image_info() {
    return $this->img;
  }
  
  public function set_image_info($url) {
    $this->img = trim($url);
    
    // the input html5 form should have check this as a url
    // here I just specify it to a http link
    // this may be changed later
    if (substr($this->img, 0, 7) == 'http://') {
      unset($this->errors['img']);
    } else {
      $this->errors['img'] = "Currently only HTTP url is accepted for image";
    }
  }

  public function get_description() {
    return $this->description;
  }
  
  public function set_description($des) {
    // currently no restriction on this :)
    
    $this->description = trim($des);
  }
  
  /*
   * init all attributes at one time
   * mainly used with the object returned from PDO fetch
   */
  public function init_from_fetched_object($obj) {
    $this->id = $obj->product_id;
    $this->name = $obj->name;
    $this->category = $obj->category;
    $this->brand = $obj->brand;
    $this->price = $obj->price;
    $this->img = $obj->imgurl;
    $this->description = $obj->description;
  }
  
  
  
  
  public function contains_error_attribute() {
    return !empty($this->errors);
  }
  
  public function get_error_array() {
    return $this->errors;
  }
  
  /*
   * add new product into db
   * return true or false
   */
  public function insert_to_db() {
    // connect to db
    $conn = get_db_connection();
    $sql = "INSERT INTO products "
            . "(name, category, brand, price, imgurl, description) VALUES "
            . "(:name,:category,:brand,:price,:imgurl,:description) "
            . "RETURNING product_id";
    $query = $conn->prepare($sql);
    $result = $query->execute(array(':name'=>  $this->name,
                                ':category'=>  $this->category,
                                ':brand'=>  $this->brand,
                                ':price'=>  $this->price,
                                ':imgurl'=>  $this->img,
                                ':description'=>  $this->description));

    if ($result) {
      $this->id = $query->fetchColumn();
    }
    return $result;
  }
  
  /*
   * updata product info in db
   * return true or false
   */
  public function update_in_db() {
    // connect to db
    $conn = get_db_connection();
    $sql = "UPDATE products SET name=?, category=?, brand =?, "
            . "price=?, imgurl=?, description=? WHERE product_id=?";

    $query = $conn->prepare($sql);
    $result = $query->execute(array($this->name, $this->category, $this->brand, 
                                    $this->price, $this->img, 
                                    $this->description, $this->id));
    return $result;
  }
  
}
