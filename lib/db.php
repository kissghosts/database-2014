<?php

/* Func that returns a connection to a database PDO structure */
function get_db_connection() {
  static $connection = null; 
  
  if ($connection == null) { 
    $connection = new PDO('pgsql:');
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }
  
  if (!$connection) {
    throw new Exception('Could not connect to database server');
  } else {
    return $connection;
  }
}