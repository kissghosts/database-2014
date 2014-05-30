<?php

class User {
  
  private $id;
  private $fname;
  private $lname;
  private $email;
  private $password;
  private $title;

  public function __construct() {
  }

  public function set_fname($fn) {
    $this->fname = $fn;
  }

  public function set_email($email) {
    $this->email = $email;
  }
  
  public function set_lname($ln) {
    $this->lname = $ln;
  }
  
  public function get_lname() {
    return $this->lname;
  }

  public function get_email() {
    return $this->email;
  }

  public function get_fname() {
    return $this->fname;
  }
}