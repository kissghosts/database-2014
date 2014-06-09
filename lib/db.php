<?php

require_once dirname(__FILE__) . '/config.php';

/* Func that returns a connection to a database PDO structure */
function get_db_connection() {
  global $PDO_PGSQL;
  static $connection = null; 
  
  if ($connection == null) { 
    $connection = new PDO($PDO_PGSQL);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }
  
  if (!$connection) {
    throw new Exception('Could not connect to database server');
  } else {
    return $connection;
  }
}