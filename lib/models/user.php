<?php

require_once(dirname(__FILE__).'/../db.php');

class User {
  
  private $id;
  private $fname;
  private $lname;
  private $email;
  private $password;
  private $title;

  public function __construct() {
    
  }
  
  /*
   * register new person with db
   * return user_id
   */
  public static function register_user_in_db($email, $passwd, $fname, $lname, $title) {
    // connect to db
    $conn = get_db_connection();
    $sql = "INSERT INTO users (title, fname, lname, email, passwd) VALUES "
          . "(:title,:fname,:lname,:email,:passwd) "
          . "RETURNING user_id";
    $query = $conn->prepare($sql);
    $result = $query->execute(array(':title'=>$title,
                                    ':fname'=>$fname,
                                    ':lname'=>$lname,
                                    ':email'=>$email,
                                    ':passwd'=>$passwd));

    if (!$result) {
      throw new Exception('Could not register, please try it later');
    }
    return $query->fetchColumn();
  }
  
  /*
   * check whether email exists in database
   * return true or false
   */
  public static function is_user_existed_in_db($email) {
    $conn = get_db_connection();
    // check whether email address exists in db
    $sql = "SELECT * from users where email = '".$email."'";
    $query = $conn->prepare($sql);
    $query->execute();
    $result = $query->fetch();
    
    if (!$result) {
      return FALSE;
    } else {
      return TRUE;
    }
  }
  
  /*
   * check whether email and password matched in database
   * if matched, return user object
   * otherelse return empty object
   */
  public static function get_user_by_email_and_passwd($email, $passwd) {
    $conn = get_db_connection();
    $sql = "SELECT * from users where email = '".$email."' and passwd = '"
            . $passwd . "'";
    $query = $conn->prepare($sql);
    $query->execute();

    $result = $query->fetch(PDO::FETCH_OBJ);
    return $result;
  }
  
  /*
   * check whether email and password matched in database
   * if matched, return user type (title)
   * otherelse return false
   */
  public static function get_user_by_userid($user_id) {
    $conn = get_db_connection();
    $sql = "SELECT * from users where user_id = ?";
    $query = $conn->prepare($sql);
    $query->execute(array($user_id));

    $result = $query->fetch(PDO::FETCH_OBJ);
    return $result;
  }

  public function set_id($id) {
    $this->id = $id;
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
  
  public function get_id() {
    return $this->id;
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
  
  public function set_passwd($passwd) {
    $this->password = $passwd;
  }
  
  public function get_passwd() {
    return $this->password;
  }
  
  public function set_title($title) {
    $this->title = $title;
  }
  
  public function get_title() {
    return $this->title;
  }
  
  public function init_from_db_object($obj) {
    $this->set_id($obj->user_id);
    $this->set_title($obj->title);
    $this->set_fname($obj->fname);
    $this->set_lname($obj->lname);
    $this->set_email($obj->email);
    $this->set_passwd($obj->passwd);
  }

}