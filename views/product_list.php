<?php
require_once "../lib/db.php";

function get_all_products() {
  $sql = "SELECT name, brand, price, image FROM products";
  $query = get_database_connection()->prepare($sql);
  $query->execute();
  
  $results = array();
  $rows = $query->fetchAll(PDO::FETCH_OBJ);
  foreach($rows as $row) {
    $product = new Product();
    $product->set_name($row->name);
    $product->set_category($row->category);

    $results[] = $product;
  }
  return $results;
}
?>