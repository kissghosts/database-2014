<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of product
 *
 * @author yfliu
 */
class Product {
  private $id;
  private $name;
  private $category;
  private $brand;
  private $price;
  private $description;
  
  public function __construct($id, $name, $category, $brand, $price, $descrpt) {
    $this->id = $id;
    $this->name = $name;
    $this->category = $category;
    $this->brand = $brand;
    $this->price = $price;
    $this->description = $descrpt;
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
  
}
