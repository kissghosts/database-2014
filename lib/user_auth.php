<?php

/* 
 * functions related to user authentication (sign-in, sign-up)
 */
require_once 'db.php';

function register($email, $passwd, $fname, $lname) {
  // register new person with db
  // return true or error message
  
  // connect to db
  $conn = get_db_connection();
  // check if username is unique
  $sql = "SELECT * from users where email='".$email."'";
  $query = $conn->prepare($sql);
  $query->execute();
  $result = $query->fetch();
  
  if ($result) {
    throw new Exception('The given email address has been taken, '
                        . 'please choose another one');
  }
  
  // if ok, put in db
  $sql = "INSERT INTO users (title, fname, lname, email, passwd) VALUES "
        . "(:title,:fname,:lname,:email,:passwd)";
  $query = $conn->prepare($sql);
  $result = $query->execute(array(':title'=>'customer',
                                  ':fname'=>$fname,
                                  ':lname'=>$lname,
                                  ':email'=>$email,
                                  ':passwd'=>$passwd));
  
  if (!$result) {
    throw new Exception('Could not register');
  }
  return true;
}

// this function is not used anymore
function login($email, $passwd) {
  // check username and password with db
  // if yes, return true
  // else throw exception
  
  // connect to db
  $conn = get_db_connection();
  // check whether email address exists in db
  $sql = "SELECT * from users where email = '".$email."'";
  $query = $conn->prepare($sql);
  $query->execute();
  $result = $query->fetch();
  
  if (!$result) {
    throw new Exception('the email address is not registered');
  }
  
  $sql = "SELECT * from users where email = '".$email."' and passwd = '"
          . $passwd . "'";
  $query = $conn->prepare($sql);
  $query->execute();
  
  $result = $query->fetch();
  
  if (!$result) {
    throw new Exception('wrong password');
  }
  
  return true;
}


