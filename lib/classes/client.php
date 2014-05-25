<?php

class Client {
  
  private $id;
  private $fname;
  private $lname;
  private $email;
  private $password;
  private $title;

  public function __construct($id, $email, $fname, $lname, $password, $title) {
    $this->id = $id;
    $this->email = $email;
    $this->fname = $fname;
    $this->lname = $lname;
    $this->password = $password;
    $this->title = $title
  }

  public function set_fname($fn) {
    $this->fname = $fn;
  }

  public function set_email($email) {
    $this->email = $email;
  }

  public function get_email() {
    return $this->email;
  }

  public function get_fname() {
    return $this->fname;
  }
}